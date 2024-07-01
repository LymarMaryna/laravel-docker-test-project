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
        Schema::create('currencies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('coin_id')->unique();
            $table->decimal('current_price', 30, 10)->nullable();
            $table->decimal('price_change_percentage_24h', 30, 10)->nullable();
            $table->text('image_url')->nullable(); // it can be more than 255 characters
            $table->decimal('market_cap', 30, 10)->nullable();
            $table->string('symbol');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
