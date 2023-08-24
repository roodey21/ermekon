<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Type;
use App\Models\Unit;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    // public function model(array $row)
    // {
    //     $types = Type::get();
    //     $type = match ($row['jenis']) {
    //         'INV' => $types->where('slug', 'bahan-baku')->first()->id,
    //         'SVC' => $types->where('slug', 'pekerjaan')->first()->id,
    //         'NON' => $types->where('slug', 'bahan-baku')->first()->id,
    //         'GROUP' => $types->where('slug', 'paket-pekerjaan')->first()->id,
    //     };

    //     return new Product([
    //        'name' => $row['nama_barang'],
    //        'code' => $row['kode_barang'],
    //        'type_id' => $type,
    //     ]);
    // }

    public function collection(Collection $rows)
    {
        // dd($rows);
        $types = Type::get();
        foreach ($rows as $row)
        {
            $type = match ($row['jenis']) {
                'INV' => $types->where('slug', 'bahan-baku')->first()->id,
                'SVC' => $types->where('slug', 'pekerjaan')->first()->id,
                'NON' => $types->where('slug', 'bahan-baku')->first()->id,
                'GROUP' => $types->where('slug', 'paket-pekerjaan')->first()->id,
            };
            $product = Product::create([
                'name' => $row['nama_barang'],
                'code' => $row['kode_barang'],
                'type_id' => $type,
            ]);
            $main_unit = Unit::where('name', $row['satuan'])->first();
            if ($main_unit) {
                $product->units()->attach($main_unit, ['conversion_factor' => 1]);
            } else {
                $product->units()->attach(Unit::first(), ['conversion_factor' => 1]);
            }
        }
    }

    public function rules(): array
    {
        return [
            '1' => Rule::in(['patrick@maatwebsite.nl']),
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
