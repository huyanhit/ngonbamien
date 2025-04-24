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
        Schema::create('sites', function (Blueprint $table) {
            $table->id();

            $table->string('logo')->nullable();
            $table->string('slogan')->nullable();
            $table->string('hotline')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();

            $table->string('company')->nullable();
            $table->string('phone')->nullable();
            $table->string('warehouse')->nullable();
            $table->string('other')->nullable();

            $table->string('link_facebook')->nullable();
            $table->string('link_youtube')->nullable();
            $table->string('link_tiktok')->nullable();

            $table->string('meta_title')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->string('meta_description')->nullable();

            $table->string('analytic')->nullable();
            $table->string('zalo')->nullable();

            $table->text('fan_page')->nullable();
            $table->text('map')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sites');
    }
};
