<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::latest()->paginate(10);
        return view('product.unit.index', compact('units'));
    }

    public function create()
    {
        return view('product.unit.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100|unique:units,name'
        ]);
        Unit::create($validated);
        return redirect()->route('unit.index');
    }

    public function edit(Unit $unit)
    {
        return view('product.unit.edit', compact('unit'));
    }

    public function update(Request $request, Unit $unit)
    {
        $validated = $request->validate([
            'name' => 'required|max:100|unique:units,name,' . $unit->id
        ]);
        $unit->update($validated);
        return redirect()->route('unit.index');
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();
        return redirect()->route('unit.index');
    }

    public function getData()
    {
        $units = Unit::latest()->get();
        return response()->json(['items' => $units]);
    }
}
