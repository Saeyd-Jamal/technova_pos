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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->date('invoice_date');
            $table->string('representative_name');
            $table->string('receiver_name');
            $table->integer('invoice_number');
            $table->integer('total_before_tax');
            $table->integer('total_tax');
            $table->integer('total_after_tax');
            $table->integer('extra_discount');
            $table->integer('total_discount');
            $table->integer('final_total');
            $table->enum('type', ['buy', 'sell','return']);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
