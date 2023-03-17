<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

use Carbon\Carbon;

class CustomersImport implements ToModel, WithHeadingRow, WithUpserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // $exists = Customer::where('phone', $row['phone'])->first();
        // // dd($exists);

        // if($exists){
        //     return Customer::findOrFail($exists->id)->update([
        //         "name" => $row['name'],
        //         "phone" => $row['phone'],
        //         "email" => $row['email'],
        //         "image" => 'uploads/customers/' . $row['image'],
        //         "address" => $row['address'],
        //         "created_at" => Carbon::now(),
        //         "updated_at" => Carbon::now()
        //     ]);
        // }
        // else {
            return new Customer([
                "name" => $row['name'],
                "phone" => $row['phone'],
                "email" => $row['email'],
                "image" => 'uploads/customers/' . $row['image'],
                "address" => $row['address'],
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ]);
        // }
    }

    public function uniqueBy()
    {
        return 'phone';
    }
}
