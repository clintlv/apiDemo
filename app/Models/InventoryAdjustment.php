<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryAdjustment extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_batch_id',
        'inventory_adjust_reason_id',
        'type',
        'quantity',
        'old_qty',
        'new_qty',
        'diff_qty',
        'operator',
        'remark',
    ];

    public function productBatch():BelongsTo
    {
        return $this->belongsTo(ProductBatch::class);
    }
    public function adjustReason():BelongsTo
    {
        return $this->belongsTo(InventoryAdjustReason::class, 'inventory_adjust_reason_id');
    }
}
