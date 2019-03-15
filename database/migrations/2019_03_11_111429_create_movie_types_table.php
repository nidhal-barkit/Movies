<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovieTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movie_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('movie_id')->unsigned()->index();
            $table->integer('type_id')->unsigned()->index();
            $table->primary(['movie_id', 'type_id']);
            $table->timestamps();
        });

        Schema::table('movie_types', function (Blueprint $table) {

            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movie_types');
    }
}
