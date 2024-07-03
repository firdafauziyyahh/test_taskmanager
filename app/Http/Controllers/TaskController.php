<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('user_id', auth()->id())->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $task = new Task;
        $task->name = $validated['name'];
        $task->description = $validated['description'];
        $task->status = 'pending';
        $task->user_id = auth()->user()->id;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('task_images', 'public');
            $task->image = $imagePath;
        }

        $task->save();

        return redirect()->route('tasks.create')->with('success', 'Task added successfully.');
    }

    public function complete(Task $task)
    {
        if ($task->user_id != auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $task->status = 'completed';
        $task->save();

        return response()->json(['success' => 'Task marked as complete.']);
    }

    public function destroy(Task $task)
    {
        if ($task->user_id != auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($task->image) {
            Storage::disk('public')->delete($task->image);
        }

        $task->delete();

        return response()->json(['success' => 'Task deleted.']);
    }
}
