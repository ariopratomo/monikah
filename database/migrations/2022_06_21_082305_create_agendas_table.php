<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            // relations with undangan master
            $table->unsignedBigInteger('undangan_id');
            //  agenda title
            $table->string('title');
            // agenda date
            $table->date('date');
            // agenda time start
            $table->time('time_start');
            // agenda time end
            $table->time('time_end');
            // agenda place
            $table->string('place');
            // agenda location
            $table->string('location');
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
        Schema::dropIfExists('agendas');
    }
};
