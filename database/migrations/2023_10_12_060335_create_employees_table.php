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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id', 255);
            $table->string('full_name', 255);
            $table->string('email', 255)->nullable();
            $table->enum('gender', ['Male', 'Female'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('martial_status', ['Single', 'Married', 'Divorced', 'Widowed'])->nullable();
            $table->enum('id_type', ['KTP'])->nullable();
            $table->string('national_id_no', 255)->nullable();
            $table->date('start_contract_date')->nullable();
            $table->date('end_contract_date')->nullable();
            $table->string('job_position', 255)->nullable();
            $table->string('bpjs_tk_no', 255)->nullable();
            $table->string('bpjs_health_no', 255)->nullable();
            $table->string('tax_id', 255)->nullable();
            $table->string('medical_insurance', 255)->nullable();
            $table->enum('work_status', ['Active', 'Non Active'])->nullable();
            $table->enum('currency', ['IDR', 'USD'])->nullable();
            $table->integer('salary')->nullable();
            $table->string('address', 255)->nullable();
            $table->foreignId('branch_office_id')->nullable()->constrained('branch_offices')->restrictOnUpdate()->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained('departments')->restrictOnUpdate()->nullOnDelete();
            $table->enum('use_gps_location', ['Yes', 'No'])->nullable();
            $table->string('password');
            $table->string('device_id', 255)->nullable();
            $table->string('token_fcm', 255)->nullable();
            $table->string('reset_token', 255)->nullable();
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
        Schema::dropIfExists('employees');
    }
};
