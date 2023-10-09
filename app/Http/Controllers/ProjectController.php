<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProjectResource;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->paginate(24);
        return inertia('Project/Index', [
            'projects' => ProjectResource::collection($projects),
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
            if ($request->client_name) {
                $customer = Customer::firstOrCreate(
                    ['name' => $request->client_name],
                    ['name' => $request->client_name, 'telephone' => $request->client_telephone]
                );
                $project->customer()->associate($customer);
                $project->save();
            }
        });
        return redirect()->route('project.index');
    }

    public function show(Project $project)
    {
        $projects = Project::latest()->get();
        return inertia('Project/Show', [
            'projects' => ProjectResource::collection($projects),
            'project' => new ProjectResource($project),
            'products' => Inertia::lazy(function () {
                $products = Product::when(request('search'), function ($product) {
                    $product->where('name', 'like', '%' . request('search') . '%');
                })->orderBy('name')->paginate(10);
                return ProductResource::collection($products);
            })
        ]);
    }
}
