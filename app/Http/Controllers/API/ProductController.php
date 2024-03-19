<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function __invoke(): AnonymousResourceCollection
    {
        return ProductResource::collection(
            Product::sorted()->get()
        );
    }
}
