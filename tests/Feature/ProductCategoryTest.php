<?php

namespace Tests\Feature;

use App\Http\Resources\ProductCategoryResource;
use App\Models\ProductCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductCategoryTest extends TestCase
{
    public function modelJsonStructure()
    {
        return ['id', 'name'];
    }

    public function testIndex()
    {
        ProductCategory::factory()->count(5)->create();

        $list = ProductCategory::paginate(20);

        $this->json('GET', 'api/product-categories', ['Accept' => 'application/json'])
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
        $this->json('POST', 'api/product-categories', [], ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJsonStructure([
                'error' => [
                    'message',
                    'validation' => ['name' => []],
                    'code'
                ]
            ]);
    }

    public function testStore()
    {
        $productCategoryData = [
            'name' => 'Category'
        ];

        $this->json('POST', 'api/product-categories', $productCategoryData, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => $this->modelJsonStructure()
            ]);
    }

    public function testShow()
    {
        $needle = ProductCategory::latest()->first();

        $this->json('GET', 'api/product-categories/' . $needle->id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => $this->modelJsonStructure()
            ]);
    }

    public function testUpdate()
    {
        $needle = ProductCategory::latest()->first();

        $needle->name = $needle->name . ' updated!';

        $this->json('PUT', 'api/product-categories/' . $needle->id, $needle->toArray(), ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => $this->modelJsonStructure()
            ]);
    }

    public function testDestroy()
    {
        $needle = ProductCategory::latest()->first();

        $this->json('DELETE','api/product-categories/' . $needle->id, [], ['Accept' => 'application/json'])
            ->assertStatus(204);
    }
}
