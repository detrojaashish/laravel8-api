<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->mediumInteger('participation_limitations')->nullable();
            $table->mediumInteger('max_no_participation_per_book')->nullable();
            $table->tinyInteger('durations')->comment('In Minutes');
            $table->tinyInteger('prepration_time')->default(0)->comment('In Minutes');
            
            $table->tinyInteger('bookable_in_advance')->default(0)->comment('In Days');
            $table->timestamps();
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
        Schema::dropIfExists('events');
    }
}
