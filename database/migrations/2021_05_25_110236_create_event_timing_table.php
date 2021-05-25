<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventTimingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_timings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('event_id');
            $table->string('day_name',20)->comment('Monday , Tuesday so on.');
            $table->time('available_from');
            $table->time('available_to');
            $table->time('not_available_from')->nullable();
            $table->time('not_available_to')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_timings');
    }
}
