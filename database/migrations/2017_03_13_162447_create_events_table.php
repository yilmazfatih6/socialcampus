<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('club_id');
            $table->text('name');
            $table->text('description');
            $table->date('date');
            $table->time('hour');
            $table->date('deadline')->nullable();
            $table->integer('attenders')->default('0');
            $table->integer('attender_limit')->nullable();
            $table->integer('price')->nullable();
            $table->bigInteger('phone')->nullable();
            $table->bigInteger('phone_alternative')->nullable();
            $table->string('poster')->default('default.png');
            $table->boolean('ended')->default('0');
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
        Schema::dropIfExists('events');
    }
}
