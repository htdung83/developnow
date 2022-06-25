<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;

interface ProductRepositoryInterface
{
    public function getListWithPagination(int $size = 20);

    public function getCurrentModel();

    public function getModelById($id);

    public function create(ProductStoreRequest $request);

    public function update(ProductUpdateRequest $request, Product $model);

    public function destroy(Product $model);
}
