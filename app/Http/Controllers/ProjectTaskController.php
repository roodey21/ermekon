<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectTaskRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\ProjectTaskResource;
use App\Models\Project;
use App\Models\ProjectTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ProjectTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        $tasks = ProjectTask::latest()->paginate(150);
        $taskStatuses = $project->taskStatuses;

        $formattedData = $taskStatuses->map(function ($status) use ($tasks) {
            return [
                'id' => $status->id,
                'name' => $status->name,
                'tasks' => ProjectTaskResource::collection(
                    $tasks->where('status_id', $status->id)
                ),
            ];
        });
        return Inertia::render('Project/Task/Index', [
            'project' => new ProjectResource($project),
            'columns' => $formattedData,
            'taskStatuses' => $taskStatuses,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Project $project, StoreProjectTaskRequest $request)
    {
        $validated = $request->validated();
        if (array_key_exists('assignees', $validated)) {
            $validated['assignees'] = json_encode($validated['assignees']);
        }
        $validated['created_by'] = auth()->user()->id;
        // dd($validated['files'][0]);

        DB::beginTransaction();
        $taskItem = $project->taskItems()->create($validated);
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $index => $file) {
                $taskItem->addMediaFromRequest('files.'.$index)->toMediaCollection('files');
            }
        }
        DB::commit();

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectTask $projectTask)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectTask $projectTask)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProjectTaskRequest $request, Project $project, ProjectTask $projectTask)
    {
        $validated = $request->validated();
        if (array_key_exists('assignees', $validated)) {
            $validated['assignees'] = json_encode($validated['assignees']);
        }
        DB::beginTransaction();
        $projectTask->update($validated);
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $index => $file) {
                $projectTask->addMediaFromRequest('files.'.$index)->toMediaCollection('files');
            }
        }
        DB::commit();
        return redirect()->back();
    }

    public function updateStatus(Project $project, ProjectTask $projectTask, Request $request)
    {
        $projectTask->update(['status_id' => $request->status_id]);
        return redirect()->back();
    }

    public function upload(ProjectTask $projectTask)
    {
        $projectTask->addMediaFromRequest('file')->toMediaCollection('files');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, ProjectTask $projectTask)
    {
        $projectTask->delete();
        return redirect()->back();
    }
}
