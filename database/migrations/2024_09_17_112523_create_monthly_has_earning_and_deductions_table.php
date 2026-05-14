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
        Schema::create('monthly_has_earning_and_deductions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained(table: 'employees')->restrictOnUpdate()->cascadeOnDelete();
            $table->string('period');
            $table->enum('status', ['earning', 'deduction']);
            $table->string('name');
            $table->integer('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_has_earning_and_deductions');
    }
};
