<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $type = [
            [
                'name' => 'pekerjaan',
                'slug' => 'pekerjaan'
            ],
            [
                'name' => 'bahan baku',
                'slug' => 'bahan-baku'
            ],
            [
                'name' => 'bahan jadi',
                'slug' => 'bahan-jadi'
            ],
            [
                'name' => 'paket pekerjaan',
                'slug' => 'paket-pekerjaan'
            ]
        ];
        foreach ($type as $type) {
            Type::create([
                'name' => $type['name'],
                'slug' => $type['slug'],
            ]);
        }
    }
}
