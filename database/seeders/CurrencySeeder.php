<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = [
            [
                'name' => 'Egyptian Pound',
                'symbol' => 'EGP',
                'code' => 'EGP',
                'primary' => 1,
            ],[
                'name' => 'United States Dollar',
                'symbol' => '$',
                'code' => 'USD',
            ],[
                'name' => 'Euro',
                'symbol' => '€',
                'code' => 'EUR',
            ]
        ];

        foreach($currencies as $currency){
            Currency::create($currency);
        }
    }
}
