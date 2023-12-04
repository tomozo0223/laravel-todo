<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with('user')->orderBy('created_at', 'desc')->paginate(5);

        return view('task.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('task.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        Gate::authorize('store-task', $request);

        Task::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => Auth::id()
        ]);

        return to_route('task.index')->with('message', '登録しました');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('task.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return view('task.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        Gate::authorize('update-task', $task);

        $task->title = $request->title;
        $task->body = $request->body;
        $task->save();

        return to_route('task.show', compact('task'))->with('message', '更新しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        Gate::authorize('delete-task', $task);

        $task->delete();

        return to_route('task.index')->with('message', '削除しました');
    }
}
