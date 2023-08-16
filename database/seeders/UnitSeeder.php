<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = ['pcs','cm','mm'];
        foreach($units as $unit){
            Unit::create([
                'name' => $unit,
            ]);
        }
    }
}
