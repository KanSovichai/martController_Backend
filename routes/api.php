<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OrderItemController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PurchaseOrderController;
use App\Http\Controllers\Api\PurchaseOrderItemController;
use App\Http\Controllers\Api\SaleOrderController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Merge these into your existing routes/api.php, or replace it if this
| is a fresh project. All routes below are prefixed with /api automatically.
|
*/

Route::apiResource('users', UserController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('suppliers', SupplierController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('sale-orders', SaleOrderController::class);
Route::apiResource('order-items', OrderItemController::class);
Route::apiResource('purchase-orders', PurchaseOrderController::class);
Route::apiResource('purchase-order-items', PurchaseOrderItemController::class);
