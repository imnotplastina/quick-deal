<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Cart\CartRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Cart;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    public function addToCart(CartRequest $request, CartService $service): JsonResponse
    {
        $cart = $service->getRelatedCart(
            customerId: $request->user()->id
        );

        $cart->products()->attach(
            $request->validated('product_id')
        );

        return new JsonResponse(
            data: ProductResource::collection(
                $cart->products
            ),
            status: Response::HTTP_CREATED
        );
    }

    public function removeFromCart(CartRequest $request, CartService $service): JsonResponse
    {
        $cart = $service->getRelatedCart(
            customerId: $request->user()->id
        );

        $cart->products()->detach(
            $request->validated('product_id')
        );

        return new JsonResponse(
            status: Response::HTTP_NO_CONTENT
        );
    }
}
