<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return Inertia::render('Product/Index', [
            'products' => ProductResource::collection($products)
        ]);
    }

    public function create()
    {
        $categories = Category::isProduct()->get();
        $units = Unit::latest()->get();
        return Inertia::render('Product/Create', [
            'categories' => $categories,
            'units' => $units
        ]);
        // return view('product.create', compact('categories', 'units'));
    }

    public function store(StoreProductRequest $request)
    {
        // dd($request->all());
        $validated = $request->safe()->only(['name','code']);
        // dd($validated);
        // saya punya 2 input yg berupa array yaitu: conversion_name[] dan conversion_factor[], jadikan kedua input tersebut menjadi satu array jika kedua input tersebut tidak kosong, misal
        // conversion_name = [ 0 => "cm", 1 => null, 2 => "m"] dan conversion_factor = [ 0 => 100, 1 => null, 2 => null]
        // maka hasilnya akan menjadi [ 0 => ["name" => "cm", "factor" => 100]]

        $conversion[] = [
            'id' => $request->unit_id,
            'factor' => 1
        ];
        if ($request->filled('conversion_id') && $request->filled('conversion_factor')) {
            foreach ($request->conversion_id as $key => $value) {
                if ($value && $request->conversion_factor[$key]) {
                    $conversion[] = [
                        'id' => $value,
                        'factor' => $request->conversion_factor[$key]
                    ];
                }
            }
        }

        DB::transaction(function () use ($validated, $request, $conversion) {
            $product = Product::create($validated);
            $product->categories()->attach($request->category_id);
            foreach ($conversion as $value) {
                $product->units()->attach($value['id'], ['conversion_factor' => $value['factor']]);
            }
        });
        return redirect()->route('product.index');
    }

    public function edit(Product $product)
    {
        $categories = Category::isProduct()->get();
        return Inertia::render('Product/Edit', [
            'product' => new ProductResource($product),
            'categories' => $categories
        ]);
        // return view('product.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->safe()->only(['name','code']);
        $conversion[] = [
            'id' => $request->unit_id,
            'factor' => 1
        ];

        if ($request->filled('conversion_id') && $request->filled('conversion_factor')) {
            foreach ($request->conversion_name as $key => $value) {
                if ($value && $request->conversion_factor[$key]) {
                    $conversion[] = [
                        'id' => $value,
                        'factor' => $request->conversion_factor[$key]
                    ];
                }
            }
        }
        // dari variable $conversion kita akan mencari unit berdasarkan nama unit, kemudian dari unit yg ditemukan tersebut kita ambil id nya lalu menambahkan data ke pivot tabel beserta conversion_factor nya
        DB::transaction(function () use ($product, $validated, $request, $conversion) {
            $product->update($validated);
            $product->categories()->sync($request->category_id);
            $product->units()->detach();
            foreach ($conversion as $key => $value) {
                $product->units()->attach($value['id'], ['conversion_factor' => $value['factor']]);
            }
        });
        return redirect()->route('product.index');
    }

    public function destroy(Product $product)
    {
        $product->categories()->detach();
        $product->units()->detach();
        $product->delete();
        return redirect()->route('product.index');
    }
}
