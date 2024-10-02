<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('place')->nullable();
            $table->string('bib')->nullable();
            $table->string('name')->nullable();
            $table->string('gender')->nullable();
            $table->string('time')->nullable();
            $table->string('age_place')->nullable();
            $table->string('team_name')->nullable();
            $table->string('team_place')->nullable();
            $table->string('team_time')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('results');
    }
}
