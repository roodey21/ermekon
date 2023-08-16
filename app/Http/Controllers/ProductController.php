<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('product.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::isProduct()->get();
        $units = Unit::latest()->get();
        return view('product.create', compact('categories', 'units'));
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->safe()->except(['unit_id','category_id']);
        // dd($validated);
        // $data['code'] = 'PRD' . rand(100, 999);
        DB::transaction(function () use ($validated, $request) {
            $product = Product::create($validated);
            $product->categories()->attach($request->category_id);
            $product->units()->attach($request->unit_id, ['conversion_factor' => 1]);
        });
        return redirect()->route('product.index');
    }

    public function edit(Product $product)
    {
        return view('product.edit', compact('product'));
    }
}
