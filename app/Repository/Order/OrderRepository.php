<?php

namespace App\Repository\Order;

use App\Contracts\Order\OrderContract;
use App\DTO\OrderDTO\IndexOrderDTO;
use App\DTO\OrderDTO\ShowOrderDTO;
use App\DTO\OrderDTO\StoreOrderDTO;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrderRepository implements OrderContract
{
    public function indexOrder(IndexOrderDTO $data, int $userId): LengthAwarePaginator
    {
        return OrderItem::with('product')
            ->whereHas('order', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->paginate(10, ['*'], 'page', $data->page);
    }
    public function storeOrder(StoreOrderDTO $data): Order
    {
        $order = Order::create([
            'user_id' => $data->user_id,
        ]);

        foreach ($data->items as $item) {

            $product = Product::findOrFail($item['product_id']);

            $itemTotalPrice = $product->price * $item['quantity'];

            $order->orderItems()->create([
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'total_price' => $itemTotalPrice,
            ]);
        }
        return $order;
    }
    public function deleteOrder(Order $order): bool
    {
        return $order->delete();
    }
    public function showOrder(ShowOrderDTO $data): Order
    {
        return Order::query()->where('uuid', $data->uuid)->first();
    }
    public function getTotalOrderSumByUserId(int $userId): float
    {
        return OrderItem::whereHas('order', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->sum('total_price');
    }
}
