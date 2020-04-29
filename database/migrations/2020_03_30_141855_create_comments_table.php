<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('user_id');
            $table->integer('parent_id')->nullable();
            $table->integer('limit')->default(5);
            $table->text('body');
            $table->string('commentable_id');
            $table->string('commentable_type');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
