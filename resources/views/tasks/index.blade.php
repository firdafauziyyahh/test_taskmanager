<!DOCTYPE html>
<html>
<head>
    <title>Task List</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Task List</h1>

    @if (session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Image</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                <tr>
                    <td>{{ $task->name }}</td>
                    <td>{{ $task->description }}</td>
                    <td>
                        @if ($task->image)
                            <img src="{{ asset('storage/' . $task->image) }}" alt="{{ $task->name }}" width="100">
                        @endif
                    </td>
                    <td>{{ $task->status }}</td>
                    <td>
                        <button class="complete-task" data-id="{{ $task->id }}">Complete</button>
                        <button class="delete-task" data-id="{{ $task->id }}">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            $('.complete-task').click(function() {
                var taskId = $(this).data('id');
                $.ajax({
                    url: '/tasks/' + taskId + '/complete',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        location.reload();
                    }
                });
            });

            $('.delete-task').click(function() {
                var taskId = $(this).data('id');
                $.ajax({
                    url: '/tasks/' + taskId,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        location.reload();
                    }
                });
            });
        });
    </script>
</body>
</html>
