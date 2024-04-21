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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->mediumText('image')->nullable();
            $table->unsignedBigInteger('shop_id');
            $table->string('unit');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
            $table->foreign('shop_id')->references('id')->on('shopkeepers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
