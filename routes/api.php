<?php

use App\Http\Controllers\Api\InventoryAdjustController;
use App\Http\Controllers\Api\UserInfoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// 用户信息
Route::apiResource('user-info', UserInfoController::class);

// 获取库存调整原因列表
Route::get('/inventory-adjust/reasons', [InventoryAdjustController::class, 'getReasonList']);
// 创建库存调整记录
Route::post('/inventory-adjust', [InventoryAdjustController::class, 'createAdjust']);
// 查询单条调整记录
Route::get('/inventory-adjust/{inventoryAdjustment}', [InventoryAdjustController::class, 'showAdjust']);
