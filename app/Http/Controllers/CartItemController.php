<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartItemStoreRequest;
use App\Http\Requests\CartItemUpdateRequest;
use App\Http\Resources\CartItemResource;
use App\Http\Resources\CartItemResourceCollection;
use App\Models\CartItem;
use App\Repositories\CartItemRepository;

class CartItemController extends Controller
{
    protected $repository;

    public function __construct(CartItemRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $list = $this->repository->getListWithPagination(\request('size', 20));

        return new CartItemResourceCollection($list);
    }

    public function store(CartItemStoreRequest $request)
    {
        $this->repository->create($request);

        return new CartItemResource($this->repository->getCurrentModel());
    }

    public function show(CartItem $cartItem)
    {
        return new CartItemResource($cartItem);
    }

    public function update(CartItemUpdateRequest $request, CartItem $cartItem)
    {
        $this->repository->update($request, $cartItem);

        return new CartItemResource($this->repository->getCurrentModel());
    }

    public function destroy(CartItem $cartItem)
    {
        $this->repository->destroy($cartItem);

        return response()->json(null, 204);
    }
}
