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
        dd($request->all());
    }

    public function getData()
    {
        $units = Unit::latest()->get();
        return response()->json(['items' => $units]);
    }
}
