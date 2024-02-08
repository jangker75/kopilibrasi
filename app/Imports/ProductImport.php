<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            'name' => $row['name'],
            'base_price' => $row['base_price'],
            'sale_price' => $row['sale_price'],
            'description' => $row['description'],
            'category_id' => $row['category'],
        ]);
    }

}
