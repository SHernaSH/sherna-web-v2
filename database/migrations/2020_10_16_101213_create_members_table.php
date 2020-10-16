<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('members', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->string('name');
            $table->unsignedInteger('order');
            $table->boolean('public')->default(false);
            $table->timestamps();
            $table->unsignedInteger('language_id')->default('1');

            $table->foreign('language_id')->references('id')->on('languages')
                ->onDelete('cascade');
            $table->primary(['id', 'language_id']);


        });


        Schema::create('actives', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedInteger('members_id');
            $table->unsignedInteger('order');
            $table->boolean('public')->default(false);
            $table->string('name');
            $table->string('img');
            $table->string('nickname');
            $table->string('email');
            $table->string('room');
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
        Schema::dropIfExists('actives');
        Schema::dropIfExists('members');
    }
}
