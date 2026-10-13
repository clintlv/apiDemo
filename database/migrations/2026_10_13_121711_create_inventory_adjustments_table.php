<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_adjustments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_batch_id')->constrained()->onDelete('restrict');
            $table->foreignId('inventory_adjust_reason_id')->constrained()->onDelete('restrict');
            $table->string('type')->comment('类型: in=入库, out=出库');
            $table->decimal('quantity',12,2)->comment('调整数量');
            $table->decimal('old_qty',12,2)->comment('变更前库存');
            $table->decimal('new_qty',12,2)->comment('变更后库存');
            $table->decimal('diff_qty',12,2)->comment('数量差值 = new-old');
            $table->string('operator')->nullable()->comment('操作人');
            $table->text('remark')->nullable()->comment('备注');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_adjustments');
    }
};
