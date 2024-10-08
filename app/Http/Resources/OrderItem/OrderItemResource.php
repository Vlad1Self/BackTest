<?php

namespace App\Http\Resources\OrderItem;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->order->user_id,
            'order_uuid' => $this->order->uuid,
            'order_created_at' => $this->order->created_at->format('Y-m-d H:i:s'),
            'product_name' => $this->product->name,
            'quantity' => $this->quantity,
            'total_price' => $this->total_price,
        ];
    }
}
