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
    public function storeOrder(StoreOrderDTO $data): Order
    {
        // Создаём новый заказ
        $order = Order::create([
            'user_id' => $data->user_id,
        ]);

        $totalOrderPrice = 0; // Переменная для расчёта общей цены заказа

        // Обрабатываем каждый элемент заказа
        foreach ($data->items as $item) {
            // Находим продукт
            $product = Product::findOrFail($item['product_id']);

            // Расчитываем цену за элемент
            $itemTotalPrice = $product->price * $item['quantity'];

            // Сохраняем элемент заказа
            $order->orderItems()->create([  // Обратите внимание на исправление: "Orderitems" на "orderItems"
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'total_price' => $itemTotalPrice, // Сохраняем стоимость элемента
            ]);

            // Добавляем к общей цене заказа
            $totalOrderPrice += $itemTotalPrice;
        }

        // Обновляем общую цену заказа в таблице orders
        $order->update(['sum_total_price' => $totalOrderPrice]);

        return $order; // Возвращаем созданный заказ
    }

    public function deleteOrder(Order $order): bool
    {
        // Сначала необходимо рассчитать сумму по удаляемым элементам
        $totalOrderPrice = $order->orderItems()->sum('total_price');
        $order->sum_total_price -= $totalOrderPrice; // Уменьшаем общую стоимость заказа

        // Удаляем все элементы заказа
        $order->orderItems()->delete();

        // Обновляем заказ
        $order->save();

        return $order->delete(); // Удаляем сам заказ
    }

    public function indexOrder(IndexOrderDTO $data, int $userId): LengthAwarePaginator
    {
        return OrderItem::with('product', 'order', 'user')
            ->whereHas('order', function ($query) use ($userId) {
                $query->where('user_id', $userId); // Фильтруем по user_id в таблице Order
            })
            ->paginate(10, ['*'], 'page', $data->page);
    }

    public function showOrder(ShowOrderDTO $data): Order
    {
        return Order::query()->where('uuid', $data->uuid)->first();
    }
}
