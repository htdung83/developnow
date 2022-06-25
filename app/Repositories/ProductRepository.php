<?php

namespace App\Repositories;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\UploadedFile;

class ProductRepository implements ProductRepositoryInterface
{
    private $model = null;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function getListWithPagination(int $size = 20)
    {
        return $this->model->latest()->paginate($size);
    }

    public function getCurrentModel()
    {
        return $this->model;
    }

    public function getModelById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(ProductStoreRequest $request)
    {
        $this->model = $this->model->create(array_merge($request->validated(), [
            'image' => $this->storeImage($request->file('photo'))
        ]));
    }

    public function update(ProductUpdateRequest $request, Product $model)
    {
        $this->model = $model;

        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['image'] = $this->storeImage($request->file('photo'));
        } else {
            $data['image'] = 'no hasFile';
        }

        $this->model->update($data);
    }

    public function destroy(Product $model)
    {
        $this->model = $model;

        $this->model->delete();
    }

    public function storeImage(UploadedFile $uploadedFile)
    {
        return $uploadedFile->storeAs('products', $uploadedFile->getClientOriginalName(), 'upload');
    }
}
