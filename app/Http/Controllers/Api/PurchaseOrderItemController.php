<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrderItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PurchaseOrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $purchaseOrderItems = PurchaseOrderItem::with(['purchaseOrder', 'product'])->get();

        return response()->json([
            'success' => true,
            'data' => $purchaseOrderItems,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'purchase_order_id' => 'required|integer|exists:purchase_orders,purchase_order_id',
            'product_id' => 'required|integer|exists:products,product_id',
            'qty_ordered' => 'required|integer|min:0',
            'qty_received' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $purchaseOrderItem = PurchaseOrderItem::create($validator->validated());

        return response()->json([
            'success' => true,
            'data' => $purchaseOrderItem->load(['purchaseOrder', 'product']),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $purchaseOrderItem = PurchaseOrderItem::with(['purchaseOrder', 'product'])->find($id);

        if (! $purchaseOrderItem) {
            return response()->json([
                'success' => false,
                'message' => 'Purchase order item not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $purchaseOrderItem,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $purchaseOrderItem = PurchaseOrderItem::find($id);

        if (! $purchaseOrderItem) {
            return response()->json([
                'success' => false,
                'message' => 'Purchase order item not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'purchase_order_id' => 'sometimes|required|integer|exists:purchase_orders,purchase_order_id',
            'product_id' => 'sometimes|required|integer|exists:products,product_id',
            'qty_ordered' => 'sometimes|required|integer|min:0',
            'qty_received' => 'sometimes|required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $purchaseOrderItem->update($validator->validated());

        return response()->json([
            'success' => true,
            'data' => $purchaseOrderItem->load(['purchaseOrder', 'product']),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $purchaseOrderItem = PurchaseOrderItem::find($id);

        if (! $purchaseOrderItem) {
            return response()->json([
                'success' => false,
                'message' => 'Purchase order item not found',
            ], 404);
        }

        $purchaseOrderItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Purchase order item deleted successfully',
        ]);
    }
}
