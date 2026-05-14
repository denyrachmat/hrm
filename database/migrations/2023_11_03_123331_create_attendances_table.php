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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->restrictOnUpdate()->cascadeOnDelete();
            $table->date('date');
            $table->string('clock_in')->nullable();
            $table->string('clock_istirahat')->nullable();
            $table->string('clock_out')->nullable();
            $table->string('latitude', 255)->nullable();
            $table->string('longitude', 255)->nullable();
            $table->string('file_attachment')->nullable(); // image clock in / att ijin sakit
            $table->string('image_istirahat')->nullable();
            $table->string('image_clock_out')->nullable();
            $table->enum('is_present', ['Yes', 'No']);
            $table->enum('description', ['Tepat Waktu', 'Terlambat', 'Izin', 'Sakit', 'Cuti']);
            $table->enum('description_istirahat', ['Tepat Waktu', 'Terlambat'])->nullable();
            $table->integer('selisih')->default(0);
            $table->text('activity')->nullable();
            $table->text('point')->nullable();
            $table->integer('meal_allowance')->default(0);
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
        Schema::dropIfExists('attendances');
    }
};
