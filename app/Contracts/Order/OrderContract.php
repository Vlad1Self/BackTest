<?php

namespace App\Contracts\Order;

use App\DTO\OrderDTO\IndexOrderDTO;
use App\DTO\OrderDTO\ShowOrderDTO;
use App\DTO\OrderDTO\StoreOrderDTO;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface OrderContract
{
    public function storeOrder(StoreOrderDTO $data): Order;
    public function indexOrder(IndexOrderDTO $data, int $userId): LengthAwarePaginator;
    public function showOrder(ShowOrderDTO $data): Order;
    public function deleteOrder(Order $order): bool;
}
