<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateInventoryAdjustRequest;
use App\Http\Resources\InventoryAdjustmentResource;
use App\Http\Resources\InventoryAdjustReasonResource;
use App\Models\InventoryAdjustment;
use App\Models\InventoryAdjustReason;
use App\Models\ProductBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryAdjustController extends Controller
{
    /**
     * 查询可用调整原因列表
     */
    public function getReasonList()
    {
        $list = InventoryAdjustReason::query()
            ->where('is_enabled', true)
            ->where('is_for_inventory_adjust', true)
            ->get();
        return InventoryAdjustReasonResource::collection($list);
    }

    /**
     * 创建库存调整记录（核心，带事务）
     */
    public function createAdjust(CreateInventoryAdjustRequest $request)
    {
        $data = $request->validated();

        // 查出批次
        $batch = ProductBatch::findOrFail($data['product_batch_id']);
        // 查出调整原因，额外校验启用状态
        $reason = InventoryAdjustReason::findOrFail($data['inventory_adjust_reason_id']);
        if(!$reason->is_enabled || !$reason->is_for_inventory_adjust){
            return response()->json(['message'=>'The adjustment reason is unavailable.'],422);
        }

        // 数据库事务
        $adjustRecord = DB::transaction(function () use ($batch, $reason, $data) {
            $oldQty = $batch->quantity;
            $newQty = $data['new_qty'];
            $diffQty = $newQty - $oldQty;

            // 创建调整流水记录
            $adjust = InventoryAdjustment::create([
                'product_batch_id' => $batch->id,
                'inventory_adjust_reason_id' => $reason->id,
                'type' => $diffQty >= 0 ? 'in' : 'out',
                'quantity' => abs($diffQty),
                'old_qty' => $oldQty,
                'new_qty' => $newQty,
                'diff_qty' => $diffQty,
                'remark' => $data['remark'] ?? null,
            ]);

            // 更新批次库存
            $batch->update([
                'quantity' => $newQty
            ]);

            return $adjust;
        });

        // 返回详情
        return new InventoryAdjustmentResource(
            $adjustRecord->load(['productBatch.product','productBatch.warehouse','adjustReason'])
        );
    }

    /**
     * 查询单条调整记录详情
     */
    public function showAdjust(InventoryAdjustment $inventoryAdjustment)
    {
        $inventoryAdjustment->load(['productBatch.product','productBatch.warehouse','adjustReason']);
        return new InventoryAdjustmentResource($inventoryAdjustment);
    }
}
