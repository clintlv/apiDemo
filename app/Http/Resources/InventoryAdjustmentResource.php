<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryAdjustmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'old_qty' => $this->new_qty - $this->diff_qty,
            'new_qty' => $this->new_qty,
            'diff_qty' => $this->diff_qty,
            'remark' => $this->remark,
            'created_at' => $this->created_at,
            'batch' => [
                'id' => $this->productBatch->id,
                'batch_no' => $this->productBatch->batch_no,
                'stock_qty' => $this->productBatch->quantity,
                'product' => [
                    'id' => $this->productBatch->product->id,
                    'name' => $this->productBatch->product->name,
                    'sku' => $this->productBatch->product->sku,
                ],
                'warehouse' => [
                    'id' => $this->productBatch->warehouse->id,
                    'name' => $this->productBatch->warehouse->name,
                    'code' => $this->productBatch->warehouse->code,
                ]
            ],
            'adjust_reason' => [
                'id' => $this->adjustReason->id,
                'name' => $this->adjustReason->name,
                'en_name' => $this->adjustReason->en_name,
            ]        ];
    }
}
