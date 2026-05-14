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
        Schema::create('deductions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->restrictOnUpdate()->cascadeOnDelete();
			$table->integer('bpjs_jht')->default(0);
            $table->integer('bpjs_jkk_jkm')->default(0);
            $table->integer('bpjs_jp')->default(0);
            $table->integer('bpjs_healt')->default(0);
            $table->integer('pph')->default(0);
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
        Schema::dropIfExists('deductions');
    }
};
