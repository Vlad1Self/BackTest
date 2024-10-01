<?php

namespace App\Http\Controllers\Product;

use App\DTO\ProductDTO\IndexProductDTO;
use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Services\Product\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function __construct(private readonly ProductService $productService)
    {
    }

    public function indexProduct(int $page): JsonResponse|AnonymousResourceCollection
    {
        $data = new IndexProductDTO(['page' => $page]);

        try {
            $products = $this->productService->indexProduct($data);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        return ProductResource::collection($products);
    }
}
