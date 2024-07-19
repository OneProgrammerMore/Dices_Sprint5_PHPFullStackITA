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
        Schema::create('dices_throws', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
			$table->uuid('user_id')->index();
			$table->bigInteger('dice_1')->unsigned();
			$table->bigInteger('dice_2')->unsigned();
			$table->bigInteger('dices_sum')->storedAs('dice_1 + dice_2')->nullable();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
			
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dices_throws');
    }
};
