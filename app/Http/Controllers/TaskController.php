<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\TaskResource;
use App\Models\Package;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Project $project, StoreTaskRequest $request)
    {
        Task::create($request->validated());
        return redirect()->back();
    }

    public function show(Project $project, Task $task)
    {
        return inertia('Project/Task/Show', [
            'project' => new ProjectResource($project),
            'task' => new TaskResource($task)
        ]);
    }
}
