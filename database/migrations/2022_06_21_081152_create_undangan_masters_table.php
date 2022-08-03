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
        Schema::create('undangan_masters', function (Blueprint $table) {
            $table->id();
            // relations with music
            $table->unsignedBigInteger('music_id')->nullable();
            $table->unsignedBigInteger('user_id');
            // relations with groom
            // $table->unsignedBigInteger('groom_id')->nullable();
            // relations with bride
            // $table->unsignedBigInteger('bride_id')->nullable();
            // relations with agenda
            // $table->unsignedBigInteger('agenda_id')->nullable();
            // relations with location
            // $table->unsignedBigInteger('location_id')->nullable();
            // relations with invited guest
            // $table->unsignedBigInteger('invited_guest_id')->nullable();
            // relations with images
            // $table->unsignedBigInteger('image_id')->nullable();
            // relation with video
            // $table->unsignedBigInteger('video_id')->nullable();
            // relations with love story
            // expired date
            $table->date('expired_date')->default(now()->addDays(10));
            // slug
            $table->string('slug');

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
        Schema::dropIfExists('undangan_masters');
    }
};
