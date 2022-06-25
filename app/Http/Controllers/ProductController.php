<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductResourceCollection;
use App\Models\Product;
use App\Repositories\ProductRepository;

class ProductController extends Controller
{
    protected $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $list = $this->repository->getListWithPagination(\request('size', 20));

        return new ProductResourceCollection($list);
    }

    public function store(ProductStoreRequest $request)
    {
        $this->repository->create($request);

        return new ProductResource($this->repository->getCurrentModel());
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        $this->repository->update($request, $product);

        return new ProductResource($this->repository->getCurrentModel());
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response(null, 204);
    }
}
