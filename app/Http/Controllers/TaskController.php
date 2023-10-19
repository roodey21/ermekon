<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\TaskResource;
use App\Models\Employee;
use App\Models\Package;
use App\Models\Product;
use App\Models\Project;
use App\Models\ProjectTask;
use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function index(Project $project)
    {
        // $tasks = Task::latest()->paginate(24);
        $tasks = ProjectTask::latest()->paginate(24);
        return inertia('Project/Task/Index', [
            'project' => new ProjectResource($project),
            'tasks' => TaskResource::collection($tasks)
        ]);
    }

    public function store(Project $project, StoreTaskRequest $request)
    {
        // dd($request->all());
        $task = Task::create($request->only(['name','package_id','description']));
        return redirect()->back()->with('success', 'Pekerjaan berhasil dibuat');
    }

    public function update(Project $project, Task $task, UpdateTaskRequest $request)
    {
        // dd($request->all());
        $task->update($request->only(['name','package_id','description','start_date','end_date']));
        $task->products()->detach();
        foreach ($request->products as $productData) {
            $product = Product::findOrFail($productData['id']);
            $task->products()->attach($product, ['volume' => $productData['volume']]); // with the volume from request
        }
        return redirect()->back()->with('success', 'Pekerjaan berhasil diupdate');
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

    public function upload(Project $project, Task $task, Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240',
        ]);
        $task->addMediaFromRequest('file')->toMediaCollection('documents');
        return redirect()->route('project.package.task.show', ['project' => $project->id, 'task' => $task->id])
            ->with('success', 'Dokumen berhasil diupload');
    }

    public function destroyDocument(Project $project, Task $task, $document)
    {
        $document = $task->documents->where('uuid', $document)->first();
        $task->deleteMedia($document);
        return redirect()->route('project.package.task.show', ['project' => $project->id, 'task' => $task->id])
            ->with('success', 'Dokumen berhasil dihapus');
    }
}
