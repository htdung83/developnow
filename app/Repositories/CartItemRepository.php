<?php

    namespace App\Repositories;

    use App\Http\Requests\CartItemStoreRequest;
    use App\Http\Requests\CartItemUpdateRequest;
    use App\Models\CartItem;
    use App\Repositories\Interfaces\CartItemRepositoryInterface;

    class CartItemRepository implements CartItemRepositoryInterface
    {
        private $model = null;

        public function __construct(CartItem $model)
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

        public function create(CartItemStoreRequest $request)
        {
            $this->model = $this->model->create(array_merge($request->validated()));
        }

        public function update(CartItemUpdateRequest $request, CartItem $model)
        {
            $this->model = $model;

            $this->model->update($request->validated());
        }

        public function destroy(CartItem $model)
        {
            $this->model = $model;

            $this->model->delete();
        }
    }
