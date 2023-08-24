<?php

namespace App\Http\Controllers;

use App\Http\Resources\UnitResource;
use App\Imports\UnitsImport;
use App\Models\Unit;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::orderBy('name')->get();
        return Inertia::render('Product/Unit/Index', [
            'units' => UnitResource::collection($units)
        ]);
        // return view('product.unit.index', compact('units'));
    }

    public function create()
    {
        return Inertia::render('Product/Unit/Create');
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
        return Inertia::render('Product/Unit/Edit', [
            'unit' => new UnitResource($unit)
        ]);
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

    public function massDestroy(Request $request)
    {
        Unit::whereIn('id', $request->ids)->delete();
        return redirect()->route('unit.index');
    }

    public function getData()
    {
        // check id there is query string named 'query' and it's not empty
        if (request()->has('query') && request('query') != '') {
            $units = Unit::where('name', 'like', '%' . request('query') . '%')->get();
        } else {
            $units = Unit::latest()->get();
        }
        return response()->json($units);
    }

    public function storeTemporary(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100|unique:units,name'
        ]);
        $unit = Unit::create($validated);
        return response()->json($unit);
    }

    public function showImportForm()
    {
        return Inertia::render('Product/Unit/Import');
    }

    public function import(Request $request)
    {
        // dd($request->all());
        Excel::import(new UnitsImport, $request->file('file'));

        return redirect()->route('unit.index');
    }
}
