<?php

namespace Database\Factories;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $productCategoryCount = ProductCategory::all()->count();

        if ($productCategoryCount == 0)
            ProductCategory::factory()->count(5)->create();

        return [
            'name' => $this->faker->name,
            'price' => $this->faker->randomFloat(2, 0.01, 100.00),
            'category_id' => ProductCategory::inRandomOrder()->first()->id,
            'image' => $this->faker->image
        ];
    }
}
