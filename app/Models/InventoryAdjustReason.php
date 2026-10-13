<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InventoryAdjustReason extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'en_name',
        'is_enabled',
        'is_for_inventory_adjust',
        'remark',
    ];

    public function inventoryAdjustments():HasMany
    {
        return $this->hasMany(InventoryAdjustment::class);
    }
}
