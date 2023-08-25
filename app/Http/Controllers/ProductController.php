<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Imports\ProductImport;
use App\Models\Product;
use App\Models\Type;
use App\Models\Unit;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name')->paginate(100);
        return Inertia::render('Product/Index', [
            'products' => ProductResource::collection($products)
        ]);
    }

    public function create()
    {
        $types = Type::get();
        $units = Unit::latest()->get();
        return Inertia::render('Product/Create', [
            'types' => $types,
            'units' => $units
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->safe()->only(['name','code','type_id']);
        $variants = $this->variantArray($request->variants);
        $conversion = $this->conversionUnitArray($request->unit_id, $request->conversion);

        DB::transaction(function () use ($validated, $conversion, $variants) {
            $product = Product::create($validated);
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
        $types = Type::get();
        $variants = Variant::orderBy('name')->get();
        return Inertia::render('Product/Edit', [
            'product' => new ProductResource($product),
            'types' => $types,
            'variants' => $variants
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->safe()->only(['name','code', 'type_id']);
        $conversion = $this->conversionUnitArray($request->unit_id, $request->conversion);
        $variants = $this->variantArray($request->variants);

        DB::transaction(function () use ($product, $validated, $conversion, $variants) {
            $product->update($validated);
            $product->units()->detach();
            foreach ($conversion as $value) {
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
        $product->units()->detach();
        $product->productVariants()->delete();
        $product->delete();
        return redirect()->route('product.index');
    }

    public function massDestroy(Request $request)
    {
        Product::whereIn('id', $request->ids)->delete();
    }

    public function showImportForm()
    {
        return Inertia::render('Product/Import');
    }

    public function import(ImportProductRequest $request)
    {
        Excel::import(new ProductImport, $request->file('file'));

        return redirect()->route('product.index');
    }

    public function variantArray($array)
    {
        $variants = [];
        if(isset($array)) {
            foreach ($array as $item) {
                $variants[] = [
                    'name' => strtolower($item['name']),
                    'values' => json_encode($item['values'])
                ];
            }
        }
        return $variants;
    }

    public function conversionUnitArray($mainUnit, $conversions)
    {
        $conversion[] = [
            'id' => $mainUnit,
            'factor' => 1
        ];
        foreach($conversions as $value) {
            if ($value['unit_id'] && $value['value']) {
                $conversion[] = [
                    'id' => $value['unit_id'],
                    'factor' => $value['value']
                ];
            }
        }
        return $conversion;
    }
}
