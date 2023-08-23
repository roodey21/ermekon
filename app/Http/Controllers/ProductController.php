<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Unit;
use App\Models\Variant;
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
        $validated = $request->safe()->only(['name','code']);

        foreach ($request->variants as $key => $variant) {
            if ($variant['name'] && $variant['values']) {
                $variants[] = [
                    'name' => strtolower($variant['name']),
                    'values' => json_encode($variant['values'])
                ];
            }
        }
        $conversion[] = [
            'id' => $request->unit_id,
            'factor' => 1
        ];
        foreach($request->conversion as $key => $value) {
            if ($value['unit_id'] && $value['value']) {
                $conversion[] = [
                    'id' => $value['unit_id'],
                    'factor' => $value['value']
                ];
            }
        }

        DB::transaction(function () use ($validated, $request, $conversion, $variants) {
            $product = Product::create($validated);
            $product->categories()->attach($request->category_id);
            foreach ($conversion as $value) {
                $product->units()->attach($value['id'], ['conversion_factor' => $value['factor']]);
            }
            foreach ($variants as $item) {
                $variant = Variant::firstOrCreate([
                    'name' => $item['name']
                ]);
                $product->productVariants()->create([
                    'variant_id' => $variant->id,
                    'values' => $item['values']
                ]);
            }
        });
        return redirect()->route('product.index');
    }

    public function edit(Product $product)
    {
        $categories = Category::isProduct()->get();
        $variants = Variant::orderBy('name')->get();
        return Inertia::render('Product/Edit', [
            'product' => new ProductResource($product),
            'categories' => $categories,
            'variants' => $variants
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->safe()->only(['name','code']);
        $conversion[] = [
            'id' => $request->unit_id,
            'factor' => 1
        ];
        foreach($request->conversion as $key => $value) {
            if ($value['unit_id'] && $value['value']) {
                $conversion[] = [
                    'id' => $value['unit_id'],
                    'factor' => $value['value']
                ];
            }
        }
        foreach ($request->variants as $key => $variant) {
            if ($variant['name'] && $variant['values']) {
                $variants[] = [
                    'name' => strtolower($variant['name']),
                    'values' => json_encode($variant['values'])
                ];
            }
        }
        DB::transaction(function () use ($product, $validated, $request, $conversion, $variants) {
            $product->update($validated);
            $product->categories()->sync($request->category_id);
            $product->units()->detach();
            foreach ($conversion as $key => $value) {
                $product->units()->attach($value['id'], ['conversion_factor' => $value['factor']]);
            }
            $product->productVariants()->delete();
            foreach ($variants as $item) {
                $variant = Variant::firstOrCreate([
                    'name' => $item['name']
                ]);
                $product->productVariants()->create([
                    'variant_id' => $variant->id,
                    'values' => $item['values']
                ]);
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
