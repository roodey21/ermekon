<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\TaskResource;
use App\Models\Employee;
use App\Models\Package;
use App\Models\Product;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::latest()->paginate(24);
        return inertia('Project/Task/Index', [
            'tasks' => TaskResource::collection($tasks)
        ]);
    }

    public function store(Project $project, StoreTaskRequest $request)
    {
        // dd($request->all());
        if($request->user_name) {
            $employee = Employee::firstOrCreate(
                ['name' => $request->user_name],
                ['name' => $request->user_name]
            );
        }
        $task = Task::create($request->only(['name','package_id','description'])+['employee_id' => $employee->id]);
        return redirect()->route('project.package.show', ['project' => $project->id, 'package' => $task->package->parent->id]);
    }

    public function update(Project $project, Task $task, StoreTaskRequest $request)
    {
        // dd($request->all());
        if($request->employee_name) {
            $employee = Employee::firstOrCreate(
                ['name' => $request->employee_name],
                ['name' => $request->employee_name]
            );
        }
        $task->update($request->only(['name','package_id','description','start_date','end_date'])+['employee_id' => $employee->id]);
        foreach ($request->products as $productData) {
            $product = Product::findOrFail($productData['id']);
            $task->products()->attach($product->id);
        }
        return redirect()->route('project.package.task.show', ['project' => $project->id, 'task' => $task->id]);
    }

    public function show(Project $project, Task $task)
    {
        $products = Product::when(request('search'), function () {
            return Product::where('name', 'like', '%' . request('search') . '%' );
        })->orderBy('name')->paginate(10);
        return inertia('Project/Task/Show', [
            'project' => new ProjectResource($project),
            'task' => new TaskResource($task),
            'products' => ProductResource::collection($products)
        ]);
    }

    public function destroy(Project $project, Task $task)
    {
        $task->delete();
        return redirect()->route('project.package.show', ['project' => $project->id, 'package' => $task->package->parent->id]);
    }
}
