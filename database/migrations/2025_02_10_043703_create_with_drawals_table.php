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
        Schema::create('with_drawals', function (Blueprint $table) {
            $table->id();
            $table->date('date_of_withdrawal');
            $table->integer('discount_amoun');
            $table->string('currancy');
            $table->text('remarks');
            $table->enum('discount_mechanism', ['active', 'archive']);
            $table->foreignId('employee_id')->nullable()->constrained('employees')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('with_drawals');
    }
};
