<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('console_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('note')->nullable();
            $table->integer('possible_players')->default(1);
            $table->string('serial_id');
            $table->string('inventory_id');
            $table->boolean('vr')->default(false);
            $table->boolean('move')->default(false);
            $table->boolean('kinect')->default(false);
            $table->boolean('game_pad')->default(false);
            $table->boolean('guitar')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
