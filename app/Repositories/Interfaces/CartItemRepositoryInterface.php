<?php
    namespace App\Repositories\Interfaces;

    use App\Http\Requests\CartItemStoreRequest;
    use App\Http\Requests\CartItemUpdateRequest;
    use App\Models\CartItem;

    interface CartItemRepositoryInterface
    {
        public function getListWithPagination(int $size = 20);

        public function getCurrentModel();

        public function getModelById($id);

        public function create(CartItemStoreRequest $request);

        public function update(CartItemUpdateRequest $request, CartItem $model);

        public function destroy(CartItem $model);
    }
