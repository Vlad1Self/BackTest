<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\OrderItem\OrderItemResource;
use App\Http\Resources\Product\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Получаем названия продуктов
        $productsNames = $this->orderItems->map(function ($orderItem) {
            return $orderItem->product ? $orderItem->product->name : 'Unknown Product';
        })->implode(', ');

        // Суммируем общую стоимость всех товаров в заказе
        $totalItemsPrice = $this->orderItems->sum('total_price');

        return [
            'order_number' => $this->uuid, // Номер заказа (UUID)
            'order_date' => $this->created_at->format('Y-m-d H:i:s'), // Дата заказа
            'products' => $productsNames, // Перечисленные названия товаров
            'total_price' => $totalItemsPrice, // Общая стоимость товаров в заказе
            'items' => OrderItemResource::collection($this->orderItems), // Коллекция элементов заказа
        ];
    }
}
