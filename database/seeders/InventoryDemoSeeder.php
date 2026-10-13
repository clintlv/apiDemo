<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\InventoryAdjustReason;
use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\Warehouse;

class InventoryDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1.预置4条预设调整原因
        InventoryAdjustReason::create([
            'name' => '实物盘点校正',
            'en_name' => 'Physical count correction',
            'is_enabled' => true,
            'is_for_inventory_adjust' => true,
        ]);
        InventoryAdjustReason::create([
            'name' => '商品损坏',
            'en_name' => 'Damaged items',
            'is_enabled' => true,
            'is_for_inventory_adjust' => true,
        ]);
        InventoryAdjustReason::create([
            'name' => '商品丢失',
            'en_name' => 'Missing items',
            'is_enabled' => true,
            'is_for_inventory_adjust' => true,
        ]);
        InventoryAdjustReason::create([
            'name' => '录入数据修正',
            'en_name' => 'Data entry correction',
            'is_enabled' => true,
            'is_for_inventory_adjust' => true,
        ]);

        // 2.仓库
        $warehouse = Warehouse::create([
            'name' => '一号仓库',
            'code' => 'WH001'
        ]);

        //3.商品
        $product = Product::create([
            'name' => '矿泉水',
            'sku' => 'WATER001'
        ]);

        //4.批次（示例场景：库存100，后续调整到92）
        ProductBatch::create([
            'warehouse_id' => $warehouse->id,
            'product_id' => $product->id,
            'batch_no' => 'B20261010',
            'quantity' => 100
        ]);
    }
}
