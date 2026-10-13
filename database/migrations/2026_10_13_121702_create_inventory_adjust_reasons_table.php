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
        Schema::create('inventory_adjust_reasons', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('原因中文名称');
            $table->string('en_name')->comment('原因英文名称');
            $table->boolean('is_enabled')->default(true)->comment('是否启用');
            $table->boolean('is_for_inventory_adjust')->default(true)->comment('是否适用于库存调整');
            $table->text('remark')->nullable()->comment('备注');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_adjust_reasons');
    }
};
