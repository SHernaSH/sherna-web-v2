<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('inventory_categories', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->string('name');
            $table->timestamps();
            $table->unsignedInteger('language_id')->default('1');

            $table->foreign('language_id')->references('id')->on('languages')
                ->onDelete('cascade');
            $table->softDeletes();
            $table->primary(['id', 'language_id']);

        });

        Schema::create('inventory_items', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('location_id');//->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('serial_id')->nullable();
            $table->string('inventory_id')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->unsignedInteger('language_id')->default('1');


            $table->foreign('location_id')->references('id')->on('locations')
                ->onDelete('cascade');

            $table->foreign('category_id')->references('id')->on('inventory_categories')
                ->onDelete('cascade');

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
        Schema::dropIfExists('inventory_items');
        Schema::dropIfExists('inventory_categories');
    }
}
