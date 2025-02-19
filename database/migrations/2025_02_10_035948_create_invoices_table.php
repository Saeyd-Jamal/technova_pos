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
            $table->string('representative_name')->comment('اسم المندوب');
            $table->string('receiver_name')->comment('اسم المستلم');
            $table->integer('invoice_number')->unique();
            $table->decimal('total_before_tax',8,2)->default(0);
            $table->decimal('total_tax',8,2)->default(0);
            $table->decimal('total_after_tax',8,2)->default(0);
            $table->enum('discount_type',['exempted','percentage','value'])->default('exempted');
            $table->decimal('discount_amount',8,2)->default(0);
            $table->decimal('extra_discount',8,2)->default(0);
            $table->decimal('total_discount',8,2)->default(0);
            $table->decimal('final_total',8,2)->default(0);
            $table->enum('type', ['buy', 'sell','return'])->default('sell');
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->nullOnDelete();
            $table->string('supplier_name')->nullable();
            $table->enum('status', ['paid', 'unpaid'])->default('paid');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
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
