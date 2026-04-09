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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->longtext('content')->nullable(); 

            $table->string('icon')->nullable();
            $table->integer('image_id')->nullable();
            $table->string('images')->nullable();

            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('warehouse')->nullable();
            $table->string('tax_code')->nullable();

            $table->integer('index')->default(1);
            $table->integer('active')->default(0);

            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_description')->nullable();
            $table->integer('auth_id')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
