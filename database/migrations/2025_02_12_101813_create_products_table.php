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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('product_category_id')->nullable();
            $table->string('code')->nullable();
            $table->string('title');
            $table->integer('image_id')->nullable();
            $table->text('description')->nullable();
            $table->string('keywords')->nullable();
            $table->longtext('content');
            $table->integer('new')->nullable();
            $table->integer('promotion')->nullable();
            $table->integer('hot')->nullable();
            $table->integer('is_hot')->nullable();
            $table->integer('is_promotion')->nullable();
            $table->integer('is_new')->nullable();
            $table->integer('price_sale')->nullable();
            $table->integer('price');
            $table->integer('active');
            $table->softDeletes();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
