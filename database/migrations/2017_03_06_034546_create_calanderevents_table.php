<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalandereventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calanderevents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Event_title', 100);
            $table->text('Event_description');
            $table->decimal('Lat', 10, 7);
            $table->decimal('Longitude', 10, 7);
            $table->integer('zip_code');
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
        Schema::dropIfExists('calanderevents');
    }
}
