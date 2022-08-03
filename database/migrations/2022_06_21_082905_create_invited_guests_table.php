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
        Schema::create('invited_guests', function (Blueprint $table) {
            $table->id();
            // relations with undangan master
            $table->unsignedBigInteger('undangan_id');
            // name of invited guest
            $table->string('name');
            // address of invited guest (optional)
            $table->string('address')->nullable();
            // telephone number of invited guest (optional)
            $table->string('telephone_number')->nullable();
            // email address of invited guest (optional)
            $table->string('email_address')->nullable();
            // slug of invited guest (optional)
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
        Schema::dropIfExists('invited_guests');
    }
};
