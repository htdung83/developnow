<?php
namespace App\Repositories;

use App\Http\Requests\ProductCategoryStoreRequest;
use App\Http\Requests\ProductCategoryUpdateRequest;
use App\Models\ProductCategory;
use App\Repositories\Interfaces\ProductCategoryRepositoryInterface;
use App\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryRepository implements ProductCategoryRepositoryInterface
{
    private $model = null;

    public function __construct(ProductCategory $model)
    {
        $this->model = $model;
    }

    public function getCurrentModel()
    {
        return $this->model;
    }

    public function getModelById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function getListWithPagination(int $size = 20)
    {
        return $this->model->latest()->paginate($size);
    }

    public function create(ProductCategoryStoreRequest $request)
    {
        $this->model = $this->model->create($request->validated());
    }

    public function update(ProductCategoryUpdateRequest $request, ProductCategory $model)
    {
        $this->model = $model;

        $this->model->update($request->validated());
    }

    public function destroy(ProductCategory $model)
    {
        $this->model = $model;

        $this->model->delete();
    }
}
