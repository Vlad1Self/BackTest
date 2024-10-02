<?php

namespace App\Services\Product;

use App\Contracts\Product\ProductContract;
use App\DTO\ProductDTO\IndexProductDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

readonly class ProductService
{
    public function __construct(private ProductContract $productRepository)
    {
    }

    public function indexProduct(IndexProductDTO $data): LengthAwarePaginator
    {
        try {
            return $this->productRepository->indexProduct($data);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw $exception;
        }
    }
}
