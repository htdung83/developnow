<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCategoryStoreRequest;
use App\Http\Requests\ProductCategoryUpdateRequest;
use App\Http\Resources\ProductCategoryResource;
use App\Http\Resources\ProductCategoryResourceCollection;
use App\Models\ProductCategory;
use App\Repositories\ProductCategoryRepository;

class ProductCategoryController extends Controller
{
    protected $repository;

    public function __construct(ProductCategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $list = $this->repository->getListWithPagination(\request('size', 20));

        return new ProductCategoryResourceCollection($list);
    }

    public function store(ProductCategoryStoreRequest $request)
    {
        $this->repository->create($request);

        return new ProductCategoryResource($this->repository->getCurrentModel());
    }

    public function show($id)
    {
        return new ProductCategoryResource($this->repository->getModelById($id));
    }

    public function update(ProductCategoryUpdateRequest $request, ProductCategory $productCategory)
    {
        $this->repository->update($request, $productCategory);

        return new ProductCategoryResource($this->repository->getCurrentModel());
    }

    public function destroy(ProductCategory $productCategory)
    {
        $this->repository->destroy($productCategory);

        return response()->json(null, 204);
    }
}
