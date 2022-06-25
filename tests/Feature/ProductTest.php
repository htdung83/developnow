<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function modelJsonStructure()
    {
        return ['id', 'name', 'price', 'category' => ['id', 'name'], 'image'];
    }

    public function testIndex()
    {
        Product::factory()->count(5)->create();

        $list = Product::paginate(request('size', 20));

        $this->json('GET', 'api/products', ['Accept' => 'application/json'])
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
        $this->json('POST', 'api/products', [], ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJsonStructure([
                'error' => [
                    'message',
                    'validation' => ['name' => []],
                    'code'
                ],
            ]);
    }

    public function testStore()
    {
        Storage::fake('fake-products');

        $needle = Product::factory()->make();

        $this->json('POST', 'api/products', array_merge($needle->toArray(), [
            'photo' => UploadedFile::fake()->image('faker.jpg')
        ]), ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => $this->modelJsonStructure()
            ]);

        Storage::disk('fake-products')->assertMissing('faker.jpg');
    }

    public function testShow()
    {
        $needle = Product::latest()->first();

        $this->json('GET', 'api/products/' . $needle->id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => $this->modelJsonStructure()
            ]);
    }

    public function testUpdate()
    {
        Storage::fake('fake-products');

        $needle = Product::latest()->first();

        $this->json('PUT', 'api/products/' . $needle->id, array_merge($needle->toArray(), [
            'name' => $needle->name . ' updated!',
            'photo' => UploadedFile::fake()->image('update-faker.jpg')
        ]), ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => $this->modelJsonStructure()
            ]);

        Storage::disk('fake-products')->assertMissing('update-faker.jpg');
    }

    public function testDestroy()
    {
        $needle = Product::latest()->first();

        $this->json('DELETE','api/products/' . $needle->id, [], ['Accept' => 'application/json'])
            ->assertStatus(204);
    }
}
