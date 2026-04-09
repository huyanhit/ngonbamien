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
        Schema::create('supplier_supports', function (Blueprint $table) {
            $table->id();
            $table->integer('supplier_id')->default(0);
            $table->integer('support_id')->default(0);
            $table->string('value_1')->default('');
            $table->string('value_2')->default('');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_supports');
    }
};
