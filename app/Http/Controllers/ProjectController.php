<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return inertia('Project/Index');
    }

    public function create()
    {
        return inertia('Project/Create');
    }

    public function store()
    {
        
    }
}
