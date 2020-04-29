<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('article_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('article_categories_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id');
            $table->string('name');
            $table->timestamps();
            $table->unsignedInteger('language_id')->default('1');

            $table->foreign('language_id')->references('id')->on('languages')
                ->onDelete('cascade');
            $table->foreign('category_id')->references('id')
                ->on('article_categories')->onDelete('cascade');
            $table->unique(['category_id', 'language_id']);
            $table->softDeletes();
        });

        Schema::create('article_category', function (Blueprint $table) {
            $table->unsignedBigInteger('article_id');
            $table->unsignedBigInteger('category_id');
            $table->nullableTimestamps();
            $table->foreign('article_id')
                ->references('id')
                ->on('articles')
                ->onDelete('cascade');
            $table->foreign('category_id')
                ->references('id')
                ->on('article_categories')
                ->onDelete('cascade');
            $table->primary(['article_id', 'category_id']);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_categories');
        Schema::dropIfExists('article_categories_details');
        Schema::dropIfExists('article_category');
    }
}
