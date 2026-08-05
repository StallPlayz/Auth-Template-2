<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();   

        return Inertia::render('Task/Index', [
            'tasks' => $tasks
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:3|max:255',
        ]);

        Task::create($request->only('title'));

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    public function update(Request $request, Task $task)
    {
        $statusbaru = $task->status === 'Belum' ? 'Selesai' : 'Belum';

        $task->update([
            'status' => $statusbaru
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task status updated successfully.');
    }
}
