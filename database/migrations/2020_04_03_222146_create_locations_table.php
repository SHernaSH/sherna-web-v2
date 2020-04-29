<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('locations', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->string('name')->unique();
            $table->unsignedInteger('status_id');
            $table->string('reader_uid')->nullable();
            $table->string('location_uid')->nullable();
            $table->unsignedInteger('language_id')->default('1');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('status_id')->references('id')
                ->on('location_statuses')->onDelete('cascade');

            $table->foreign('language_id')->references('id')->on('languages')
                ->onDelete('cascade');
            $table->primary(['id', 'language_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
}
