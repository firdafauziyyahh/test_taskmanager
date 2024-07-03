<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task = new Task;
        $task->name = $validated['name'];
        $task->description = $validated['description'];
        $task->status = 'pending';
        $task->user_id = auth()->user()->id;
        $task->save();

        return redirect()->route('tasks.create')->with('success', 'Task added successfully.');
    }

    public function __construct()
{
    $this->middleware('auth');
}

}
