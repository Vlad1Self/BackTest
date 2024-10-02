<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\OrderItem\OrderItemResource;
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
        $productsNames = $this->orderItems->map(function ($orderItem) {
            return $orderItem->product ? $orderItem->product->name : 'Unknown Product';
        })->implode(', ');

        $totalItemsPrice = $this->orderItems->sum('total_price');

        return [
            'order_number' => $this->uuid,
            'order_date' => $this->created_at->format('Y-m-d H:i:s'),
            'products' => $productsNames,
            'total_price' => $totalItemsPrice,
            'items' => OrderItemResource::collection($this->orderItems),
        ];
    }
}
