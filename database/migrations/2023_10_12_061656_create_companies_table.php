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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name', 255);
            $table->string('app_name', 255);
            $table->text('address');
            $table->string('phone');
            $table->string('logo')->nullable();;
            $table->string('email_remainder_first')->unique();
            $table->string('email_remainder_second')->unique();
            $table->string('start_clock_in');
            $table->string('start_clock_out_saturday');
            $table->string('start_clock_out');
            $table->string('late_absence');
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
        Schema::dropIfExists('companies');
    }
};
