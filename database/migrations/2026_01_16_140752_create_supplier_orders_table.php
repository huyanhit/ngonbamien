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
        Schema::create('supplier_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('supplier_id');
            $table->integer('order_id')->default(0);
            $table->integer('order_status_id')->default(0);
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->integer('sex')->nullable();
            $table->integer('ship_type')->nullable();
            $table->string('coupon')->nullable();
            $table->integer('payment')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('ship_price')->nullable();
            $table->integer('down_price')->nullable();
            $table->integer('total')->nullable();
            $table->text('note')->nullable();
            $table->integer('user_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_orders');
    }
};
