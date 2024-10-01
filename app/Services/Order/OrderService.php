<?php

namespace App\Services\Order;

use App\Contracts\Order\OrderContract;
use App\DTO\OrderDTO\IndexOrderDTO;
use App\DTO\OrderDTO\ShowOrderDTO;
use App\DTO\OrderDTO\StoreOrderDTO;
use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

readonly class OrderService
{
    public function __construct(private OrderContract $orderRepository)
    {
    }

    public function storeOrder(StoreOrderDTO $data): Order
    {
        try {
            return $this->orderRepository->storeOrder($data);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw $exception;
        }
    }
    public function indexOrder(IndexOrderDTO $data, int $userId): LengthAwarePaginator
    {
        try {
            return $this->orderRepository->indexOrder($data, $userId);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw $exception;
        }
    }

    public function showOrder(ShowOrderDTO $data): Order
    {
        try {
            return $this->orderRepository->showOrder($data);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw $exception;
        }
    }

    public function deleteOrder(ShowOrderDTO $data): bool
    {
        try {
            $order = $this->orderRepository->showOrder($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }

        if (!$order) {
            throw new \Exception('Order not found');
        }

        try {
            return $this->orderRepository->deleteOrder($order);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw $exception;
        }
    }
}
