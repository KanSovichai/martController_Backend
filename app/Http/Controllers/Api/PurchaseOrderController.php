<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $purchaseOrders = PurchaseOrder::with(['supplier', 'user'])->get();

        return response()->json([
            'success' => true,
            'data' => $purchaseOrders,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required|integer|exists:suppliers,supplier_id',
            'user_id' => 'required|integer|exists:users,users_id',
            'order_date' => 'required|date',
            'received_date' => 'nullable|date',
            'status' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $purchaseOrder = PurchaseOrder::create($validator->validated());

        return response()->json([
            'success' => true,
            'data' => $purchaseOrder->load(['supplier', 'user']),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $purchaseOrder = PurchaseOrder::with(['supplier', 'user', 'purchaseOrderItems.product'])->find($id);

        if (! $purchaseOrder) {
            return response()->json([
                'success' => false,
                'message' => 'Purchase order not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $purchaseOrder,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $purchaseOrder = PurchaseOrder::find($id);

        if (! $purchaseOrder) {
            return response()->json([
                'success' => false,
                'message' => 'Purchase order not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'supplier_id' => 'sometimes|required|integer|exists:suppliers,supplier_id',
            'user_id' => 'sometimes|required|integer|exists:users,users_id',
            'order_date' => 'sometimes|required|date',
            'received_date' => 'nullable|date',
            'status' => 'sometimes|required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $purchaseOrder->update($validator->validated());

        return response()->json([
            'success' => true,
            'data' => $purchaseOrder->load(['supplier', 'user']),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $purchaseOrder = PurchaseOrder::find($id);

        if (! $purchaseOrder) {
            return response()->json([
                'success' => false,
                'message' => 'Purchase order not found',
            ], 404);
        }

        $purchaseOrder->delete();

        return response()->json([
            'success' => true,
            'message' => 'Purchase order deleted successfully',
        ]);
    }
}
