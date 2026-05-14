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
        Schema::create('izinsakits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->restrictOnUpdate()->cascadeOnDelete();
			$table->date('date');
			$table->enum('description', ['Izin', 'Sakit']);
			$table->text('detailed_description')->nullable();
			$table->enum('status', ['Waiting', 'Approved', 'Rejected']);
			$table->string('file_attachment')->nullable();
            $table->text('note_review')->nullable();
            $table->foreignId('user_review')->nullable()->constrained('users')->nullOnDelete();
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
        Schema::dropIfExists('izinsakits');
    }
};
