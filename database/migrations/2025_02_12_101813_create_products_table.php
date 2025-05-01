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

            $table->string('sku')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->longtext('content')->nullable();

            $table->integer('image_id')->nullable();
            $table->string('images')->nullable();

            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_description')->nullable();

            $table->integer('status')->default(1);
            $table->integer('active')->default(1);

            $table->integer('product_category_id')->nullable();
            $table->integer('producer_id')->nullable();

            $table->string('tags')->nullable();

            $table->integer('is_hot')->nullable();
            $table->integer('is_promotion')->nullable();
            $table->integer('is_new')->nullable();

            $table->integer('view')->nullable();

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
