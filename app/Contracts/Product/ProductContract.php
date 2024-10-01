<?php

namespace App\Contracts\Product;

use App\DTO\ProductDTO\IndexProductDTO;
use App\DTO\ProductDTO\ShowProductDTO;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProductContract
{
    public function indexProduct(IndexProductDTO $data): LengthAwarePaginator;
    public function showProduct(ShowProductDTO $data): Product;
}
