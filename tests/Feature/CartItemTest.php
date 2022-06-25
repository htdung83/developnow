<?php

namespace Tests\Feature;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductCategory;
use Tests\TestCase;

class CartItemTest extends TestCase
{
    public function modelJsonStructure()
    {
        return ['id', 'product' => [
            'id', 'name', 'price', 'category' => ['id', 'name']
        ]];
    }

    public function testIndex()
    {
        $productCategoryCount = ProductCategory::all()->count();
        if ($productCategoryCount == 0)
            ProductCategory::factory()->count(5)->create();

        $productCount = Product::all()->count();
        if ($productCount == 0)
            Product::factory()->count(5)->create();

        CartItem::factory()->count(5)->create();

        $list = CartItem::paginate(request('size', 20));

        $this->json('GET', 'api/cart-items', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    $this->modelJsonStructure()
                ],
                'links' => [
                    'first', 'last', 'prev', 'next'
                ],
                'meta' => [
                    'current_page',
                    'from',
                    'last_page',
                    'links' => [
                        ['url', 'label', 'active']
                    ],
                    'path',
                    'per_page',
                    'to',
                    'total'
                ]
            ]);
    }

    public function testInputValidationFailed()
    {
        $this->json('POST', 'api/cart-items', [], ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJsonStructure([
                'error' => [
                    'message',
                    'validation' => ['product_id' => []],
                    'code'
                ]
            ]);
    }

    public function testStore()
    {
        Product::factory()->make();
        $needle = Product::latest()->first();

        $CartItemData = [
            'product' => $needle->id
        ];

        $this->json('POST', 'api/cart-items', $CartItemData, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => $this->modelJsonStructure()
            ]);
    }

    public function testShow()
    {
        CartItem::factory()->make();
        $needle = CartItem::latest()->first();

        $this->json('GET', 'api/cart-items/' . $needle->id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => $this->modelJsonStructure()
            ]);
    }

    public function testUpdate()
    {
        CartItem::factory()->make();
        $needle = CartItem::latest()->first();

        $newProduct = Product::inRandomOrder()->first();

        $this->json('PUT', 'api/cart-items/' . $needle->id, array_merge($needle->toArray(),[
            'product' => $newProduct->id
        ]), ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => $this->modelJsonStructure()
            ]);
    }

    public function testDestroy()
    {
        CartItem::factory()->make();
        $needle = CartItem::latest()->first();

        $this->json('DELETE','api/cart-items/' . $needle->id, [], ['Accept' => 'application/json'])
            ->assertStatus(204);
    }
}
