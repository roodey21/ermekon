<?php

namespace App\Http\Controllers;

use App\Http\Requests\Package\StorePackageRequest;
use App\Http\Requests\Package\StoreSubPackageRequest;
use App\Http\Resources\PackageResource;
use App\Http\Resources\ProjectResource;
use App\Models\Package;
use App\Models\Project;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function show(Project $project, Package $package)
    {
        return inertia('Project/Package/Show', [
            'project' => new ProjectResource($project),
            'taskPackage' => new PackageResource($package)
        ]);
    }

    public function store(Project $project, StorePackageRequest $request)
    {
        $project->packages()->create($request->validated());
        return redirect()->back();
    }

    public function storeSubPackage(Project $project, StoreSubPackageRequest $request)
    {
        $project->packages()->create($request->validated());
        return redirect()->back();
    }
}
