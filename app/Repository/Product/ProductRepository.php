<?php

namespace App\Repository\Product;

use App\Contracts\Product\ProductContract;
use App\DTO\ProductDTO\IndexProductDTO;
use App\DTO\ProductDTO\ShowProductDTO;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductContract
{
    public function indexProduct(IndexProductDTO $data): LengthAwarePaginator
    {
        return Product::query()->paginate(10, ['*'], 'page', $data->page);
    }

    public function showProduct(ShowProductDTO $data): Product
    {
        return Product::query()->findOrFail($data->id);
    }
}
