<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Customer;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->paginate(24);
        return inertia('Project/Index', [
            'projects' => ProjectResource::collection($projects)
        ]);
    }

    public function create()
    {
        return inertia('Project/Create');
    }

    public function store(StoreProjectRequest $request)
    {
        DB::transaction(function () use ($request) {
            $project = Project::create($request->validated());
            $customer = Customer::firstOrCreate(
                ['name' => $request->client_name],
                ['name' => $request->client_name, 'telephone' => $request->client_telephone]
            );
            $project->customer()->associate($customer);
            $project->save();
        });
        return redirect()->back();
    }

    public function show(Project $project)
    {
        return inertia('Project/Show', [
            'project' => new ProjectResource($project)
        ]);
    }
}
