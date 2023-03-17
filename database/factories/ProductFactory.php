<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'refrence_no' => $this->faker->regexify('[A-Za-z0-9]{10}'),
            'name' => $this->faker->name(),
            'description' => $this->faker->text(200),
            'image' => $this->faker->imageUrl(640, 480, 'fashion', true),
            'cost_price' => $this->faker->randomFloat('2', 1000, 3000),
            'sale_price' => $this->faker->randomFloat('2', 1000, 3000),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
