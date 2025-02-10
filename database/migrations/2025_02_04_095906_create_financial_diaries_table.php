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
        Schema::create('financial_diaries', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('day');
            $table->integer('cash_inventory');
            $table->integer('operating_cost');
            $table->integer('net_income');
            $table->integer('profit_percentage');
            $table->integer('gross_profit');
            $table->integer('remaining_profit');
            $table->integer('daily_purchases');
            $table->integer('daily_sales');
            $table->integer('daily_tax_collected');
            $table->integer('discount_given');
            $table->text('remarks');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_diaries');
    }
};
