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
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->integer('unit_price_before_tax');
            $table->integer('tax_rate');
            $table->integer('tax_amount');
            $table->integer('unit_price_after_tax');
            $table->integer('total_price_before_tax');
            $table->integer('total_price_after_tax');
            $table->integer('discount_amount');
            $table->integer('final_price');
            $table->foreignId('invoice_id');
            $table->foreignId('stock_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_details');
    }
};
