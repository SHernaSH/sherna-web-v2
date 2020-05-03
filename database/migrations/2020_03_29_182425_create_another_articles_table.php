<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnotherArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('url')->unique();
            $table->uuid('user_id');
            $table->boolean('public')->default(false);
            $table->boolean('comments_enabled')->default(true);
            $table->nullableTimestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')
                ->on('users');
        });

        Schema::create('articles_text', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('article_id');
            $table->string('title');
            $table->string('description');
            //$table->string('category'); //TODO Add this
            $table->text('content')->nullable();
            $table->nullableTimestamps();
            $table->unsignedInteger('language_id')->default('1');

            $table->foreign('language_id')->references('id')->on('languages')
                ->onDelete('cascade');
            $table->foreign('article_id')->references('id')
                ->on('articles')->onDelete('cascade');
            $table->unique(['article_id', 'language_id']);
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
        Schema::dropIfExists('articles_text');
        Schema::dropIfExists('articles');

    }
}
