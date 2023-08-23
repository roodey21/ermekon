<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function store(Request $request)
    {
        dd($request->all());
        $validated = $request->validate([
            'name' => 'required|max:100|unique:units,name'
        ]);
        $unit = Unit::create($validated);
        return response()->json($unit);
    }
}
