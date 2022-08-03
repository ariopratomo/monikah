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
        Schema::create('gifts', function (Blueprint $table) {
            $table->id();
            // relations with undangan master
            $table->unsignedBigInteger('undangan_id');
            // relation with bank
            $table->unsignedBigInteger('bank_id');
            // gift bank account number or ewallet account number
            $table->string('account_number');
            // gift bank account name or ewallet account name
            $table->string('account_name');
            // gift qr code
            $table->string('qr_code')->nullable();
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
        Schema::dropIfExists('gifts');
    }
};
