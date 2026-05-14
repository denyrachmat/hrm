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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
			$table->foreignId('categorynews_id')->nullable()->constrained('categorynews')->restrictOnUpdate()->nullOnDelete();
			$table->string('thumbnail')->nullable();
			$table->foreignId('user_id')->nullable()->constrained('users')->restrictOnUpdate()->nullOnDelete();
			$table->date('date');
			$table->text('description');
			$table->string('file_attachment')->nullable();
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
        Schema::dropIfExists('news');
    }
};
