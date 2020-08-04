<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->uuid('salt');
            $table->unsignedInteger('points');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->unsignedInteger('location_id');

            $table->foreign('location_id')->references('id')
                ->on('locations')->onDelete('cascade');

            $table->softDeletes();
        });

        Schema::create('event_user', function (Blueprint $table) {
            $table->foreignId('event_id')->constrained()->onDelete('cascade');;
            $table->uuid('user_id');

            $table->primary(['event_id', 'user_id']);

            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_user');
        Schema::dropIfExists('events');
    }
}
