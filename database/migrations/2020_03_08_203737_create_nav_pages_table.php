<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNavPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('nav_pages', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->string('url');
            $table->string('name');
            $table->unsignedInteger('order');
            $table->boolean('public')->default(false);
            $table->boolean('dropdown')->default(false);
            $table->string('special_code')->nullable();
            $table->timestamps();
            $table->unsignedInteger('language_id')->default('1');

            $table->foreign('language_id')->references('id')->on('languages')
                ->onDelete('cascade');
            $table->primary(['id', 'language_id']);
            $table->unique(['url', 'language_id']);
//            $table->unique(['order', 'language_id']);


        });


        Schema::create('nav_subpages', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->unsignedInteger('nav_page_id');
            $table->unsignedInteger('order');
            $table->boolean('public')->default(false);
            $table->string('url');
            $table->string('name');
            $table->timestamps();
            $table->unsignedInteger('language_id')->default('1');

            $table->foreign('language_id')->references('id')->on('languages')
                ->onDelete('cascade');
            $table->foreign('nav_page_id')->references('id')
                ->on('nav_pages')->onDelete('cascade');
            $table->primary(['id', 'language_id']);

//            $table->unique(['order', 'language_id']);


        });

        Schema::create('nav_subpages_text', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('nav_subpage_id');
            $table->string('title');
            $table->text('content')->nullable();
            $table->timestamps();
            $table->unsignedInteger('language_id')->default('1');

            $table->foreign('language_id')->references('id')->on('languages')
                ->onDelete('cascade');;
            $table->foreign('nav_subpage_id')->references('id')
                ->on('nav_subpages')->onDelete('cascade');
            $table->unique(['nav_subpage_id', 'language_id']);

        });

        Schema::create('nav_pages_text', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('nav_page_id');
            $table->string('title');
            $table->text('content')->nullable();
            $table->timestamps();
            $table->unsignedInteger('language_id')->default('1');

            $table->foreign('language_id')->references('id')->on('languages')
                ->onDelete('cascade');;
            $table->foreign('nav_page_id')->references('id')
                ->on('nav_pages')->onDelete('cascade');
            $table->unique(['nav_page_id', 'language_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nav_subpages_text');
        Schema::dropIfExists('nav_pages_text');
        Schema::dropIfExists('nav_subpages');
        Schema::dropIfExists('nav_pages');


    }
}
