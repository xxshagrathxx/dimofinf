<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'name'              =>'Super Admin',
            'email'             =>'admin@site.com',
            'password'          =>Hash::make('123456789'),
            'profile_photo_path'=>'default_imgs/default_avatar.png',
        ]);
        // \App\Models\User::factory(10)->create();
		// $this->call(ProductSeeder::class);
        $this->call(CurrencySeeder::class);
    }
}
