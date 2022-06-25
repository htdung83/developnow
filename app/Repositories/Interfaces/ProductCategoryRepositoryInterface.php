<?php

    namespace App\Repositories\Interfaces;

    use App\Http\Requests\ProductCategoryStoreRequest;
    use App\Http\Requests\ProductCategoryUpdateRequest;
    use App\Models\ProductCategory;

    interface ProductCategoryRepositoryInterface
    {
        public function getListWithPagination(int $size = 20);

        public function getCurrentModel();

        public function getModelById($id);

        public function create(ProductCategoryStoreRequest $request);

        public function update(ProductCategoryUpdateRequest $request, ProductCategory $model);

        public function destroy(ProductCategory $model);
    }
