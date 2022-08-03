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
        Schema::create('love_stories', function (Blueprint $table) {
            $table->id();
            // relations with undangan master
            $table->unsignedBigInteger('undangan_id');
            // love story title
            $table->string('title');
            // love story content
            $table->text('content');
            // place of love story
            $table->string('place');
            // date of love story
            $table->date('date');
            // image url
            $table->string('image_url')->nullable();
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
        Schema::dropIfExists('love_stories');
    }
};
