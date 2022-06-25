<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $product = Product::inRandomOrder()->first();

        if (! $product) {
            Product::factory()->count(5)->create();
        }

        return [
            'product_id' => Product::latest()->first()->id
        ];
    }
}
