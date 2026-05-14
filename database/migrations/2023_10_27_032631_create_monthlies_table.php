<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthlies', function (Blueprint $table) {
            $table->id();
            // data employee
            $table->foreignId('employee_id')->constrained(table: 'employees')->restrictOnUpdate()->cascadeOnDelete();
            $table->string('period');
            $table->enum('payroll_type', ['monthly', 'daily', 'monthly_and_daily']);
            $table->string('currency');
            $table->integer('salary_monthly')->default(0);
            $table->integer('salary_per_day')->default(0);
            $table->integer('craft_incentives')->default(0);
            // absen
            $table->integer('jumlah_hari_kerja')->default(0);
            $table->integer('jumlah_masuk')->default(0);
            $table->integer('telat_absen')->default(0);
            // benefit
            $table->integer('total_earnings')->default(0);
            $table->integer('salary_daily')->default(0);
            $table->integer('craft_incentives_payroll')->default(0);
            $table->integer('meal_allowance_payroll')->default(0);
            // potongan
            $table->integer('total_deductions')->default(0);
            $table->integer('potongan_telat_absen')->default(0);
            $table->integer('final_salary')->default(0);
            $table->enum('is_send', ['Yes', 'No'])->default('No')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monthlies');
    }
};
