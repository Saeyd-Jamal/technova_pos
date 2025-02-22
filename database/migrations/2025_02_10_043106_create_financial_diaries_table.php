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
            $table->date('date')->unique();
            $table->string('day');
            $table->decimal('cash_inventory',8,2)->default(0);
            $table->decimal('operating_cost',8,2)->default(0);
            $table->decimal('net_income',8,2)->default(0);
            $table->decimal('profit_percentage',8,2)->default(0);
            $table->decimal('gross_profit',8,2)->default(0);
            $table->decimal('remaining_profit',8,2)->default(0);
            $table->decimal('daily_purchases',8,2)->default(0);
            $table->decimal('daily_sales',8,2)->default(0);
            $table->decimal('daily_tax_collected',8,2)->default(0);
            $table->decimal('discount_given',8,2)->default(0);
            $table->text('remarks')->nullable();
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
