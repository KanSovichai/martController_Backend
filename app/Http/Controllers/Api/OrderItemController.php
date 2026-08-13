<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $orderItems = OrderItem::with(['saleOrder', 'product'])->get();

        return response()->json([
            'success' => true,
            'data' => $orderItems,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|integer|exists:sale_orders,order_id',
            'product_id' => 'required|integer|exists:products,product_id',
            'quantity_sold' => 'required|integer|min:1',
            'unit_price_sale' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $orderItem = OrderItem::create($validator->validated());

        return response()->json([
            'success' => true,
            'data' => $orderItem->load(['saleOrder', 'product']),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $orderItem = OrderItem::with(['saleOrder', 'product'])->find($id);

        if (! $orderItem) {
            return response()->json([
                'success' => false,
                'message' => 'Order item not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $orderItem,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $orderItem = OrderItem::find($id);

        if (! $orderItem) {
            return response()->json([
                'success' => false,
                'message' => 'Order item not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'order_id' => 'sometimes|required|integer|exists:sale_orders,order_id',
            'product_id' => 'sometimes|required|integer|exists:products,product_id',
            'quantity_sold' => 'sometimes|required|integer|min:1',
            'unit_price_sale' => 'sometimes|required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $orderItem->update($validator->validated());

        return response()->json([
            'success' => true,
            'data' => $orderItem->load(['saleOrder', 'product']),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $orderItem = OrderItem::find($id);

        if (! $orderItem) {
            return response()->json([
                'success' => false,
                'message' => 'Order item not found',
            ], 404);
        }

        $orderItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Order item deleted successfully',
        ]);
    }
}
