<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SaleOrder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SaleOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $saleOrders = SaleOrder::with(['user', 'orderItems'])->get();

        return response()->json([
            'success' => true,
            'data' => $saleOrders,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'payment_method' => 'required|string|max:255',
            'total_amount' => 'required|numeric|min:0',
            'user_id' => 'required|integer|exists:users,users_id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $saleOrder = SaleOrder::create($validator->validated());

        return response()->json([
            'success' => true,
            'data' => $saleOrder->load('user'),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $saleOrder = SaleOrder::with(['user', 'orderItems.product'])->find($id);

        if (! $saleOrder) {
            return response()->json([
                'success' => false,
                'message' => 'Sale order not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $saleOrder,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $saleOrder = SaleOrder::find($id);

        if (! $saleOrder) {
            return response()->json([
                'success' => false,
                'message' => 'Sale order not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'payment_method' => 'sometimes|required|string|max:255',
            'total_amount' => 'sometimes|required|numeric|min:0',
            'user_id' => 'sometimes|required|integer|exists:users,users_id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $saleOrder->update($validator->validated());

        return response()->json([
            'success' => true,
            'data' => $saleOrder->load('user'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $saleOrder = SaleOrder::find($id);

        if (! $saleOrder) {
            return response()->json([
                'success' => false,
                'message' => 'Sale order not found',
            ], 404);
        }

        $saleOrder->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sale order deleted successfully',
        ]);
    }
}
