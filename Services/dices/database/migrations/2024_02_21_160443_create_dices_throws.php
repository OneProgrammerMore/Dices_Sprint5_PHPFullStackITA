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
            $table->id('throw_id');
            $table->timestamps();
            
			$table->bigInteger('player_id')->unsigned()->index();
			
			$table->bigInteger('dice_1')->unsigned();
			$table->bigInteger('dice_2')->unsigned();
			
			//Laravel does not support generation in schema
			//$table->bigInteger('dices_sum')->unsigned()->nullable();
			//Okay it does..
			$table->bigInteger('dices_sum')->storedAs('dice_1 + dice_2')->nullable();
			
			//Therefore i need to use raw SQL (Outside thta table creation)
			//Or a virtual column (Not stored in the database but calculated when it is queried
			//Commented as example
			//$table->integer('dices_sum')->virtualAs('dice_1 + dice_2');
			
			
			$table->foreign('player_id')->references('id')->on('users')->onDelete('cascade');
			
        });
		//DB::statement('UPDATE dices_throws SET dices_sum = dice_1 + dice_2');
			
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //Schema::dropIfExists('dices_throws');
    }
};
