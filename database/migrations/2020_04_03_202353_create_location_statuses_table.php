<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('location_statuses', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->string('name')->unique();
            $table->boolean('opened')->default(false);
            $table->timestamps();
            $table->unsignedInteger('language_id')->default('1');

            $table->foreign('language_id')->references('id')->on('languages')
                ->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('location_statuses');
    }
}
