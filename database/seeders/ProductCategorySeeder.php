<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create 4 categories for product model with value is pekerjaan, bahan baku, bahan jadi, paket pekerjaan
        $productCategories = ['pekerjaan', 'bahan baku', 'bahan jadi', 'paket pekerjaan'];
        foreach ($productCategories as $productCategory) {
            Category::create([
                'name' => $productCategory,
                'slug' => \Str::slug($productCategory),
                'type' => 'product',
            ]);
        }
    }
}
