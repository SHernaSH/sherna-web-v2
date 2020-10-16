<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('reservations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('location_id');
            $table->uuid('user_id');
            $table->unsignedInteger('visitors_count')->nullable();
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->dateTime('entered_at')->nullable();
            $table->boolean('extra')->default(false);
            $table->unsignedInteger('extra_hours')->default(0);
            $table->boolean('vr')->default(false);
            $table->string('note')->nullable();
//            $table->dateTime('cancelled_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('location_id')->references('id')
                ->on('locations')->onDelete('cascade');

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
        Schema::dropIfExists('reservations');
    }
}
