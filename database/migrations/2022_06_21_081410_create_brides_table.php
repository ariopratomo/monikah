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
        Schema::create('brides', function (Blueprint $table) {
            // relations with undangan master
            $table->unsignedBigInteger('undangan_id');
            $table->id();
            // nicakname
            $table->string('nickname');
            // name
            $table->string('name');
            // parents name
            $table->string('parents_name');
            // address
            $table->string('address');
            // any other info
            $table->string('other_info');
            // social media links
            $table->string('facebook_link')->nullable();
            $table->string('instagram_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('tiktok_link')->nullable();
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
        Schema::dropIfExists('brides');
    }
};
