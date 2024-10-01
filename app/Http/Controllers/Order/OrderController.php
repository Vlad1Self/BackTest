<?php

namespace App\Http\Controllers\Order;

use App\DTO\OrderDTO\IndexOrderDTO;
use App\DTO\OrderDTO\ShowOrderDTO;
use App\DTO\OrderDTO\StoreOrderDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Resources\Order\OrderResource;
use App\Http\Resources\OrderItem\OrderItemResource;
use App\Models\Order;
use App\Services\Order\OrderService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function __construct(private readonly OrderService $orderService)
    {
    }

    public function index(int $userId, int $page): JsonResponse|AnonymousResourceCollection
    {
        $data = new IndexOrderDTO(['page' => $page]);

        try {
            $orderItems = $this->orderService->indexOrder($data, $userId);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        return OrderItemResource::collection($orderItems);
    }



    public function store(StoreOrderRequest $request): JsonResponse|OrderResource
    {
        $data = new StoreOrderDTO($request->validated());

        try {
            $order =$this->orderService->storeOrder($data);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
        return new OrderResource($order);
    }

    public function delete(string $uuid): JsonResponse
    {
        $data = new ShowOrderDTO(['uuid' => $uuid]);

        try {
            $this->orderService->deleteOrder($data);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }

        return response()->json(['data' => 'Order deleted']);
    }

}
