<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Carbon\Carbon;

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            "refrence_no" => $row['refrence_no'],
            "name" => $row['name'],
            "description" => $row['description'],
            "image" => 'uploads/products/' . $row['image'],
            "cost_price" => $row['cost_price'],
            "sale_price" => $row['sale_price'],
            "category_id" => $row['category_id'],
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now()
        ]);
    }
}
