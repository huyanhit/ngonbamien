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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id');
            $table->string('title');
            $table->text('content')->nullable();
            $table->string('icon')->nullable();
            $table->string('banner')->nullable();
            $table->integer('image_id')->nullable();
            $table->integer('index')->default(1);
            $table->integer('active')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_categories');
    }
};
