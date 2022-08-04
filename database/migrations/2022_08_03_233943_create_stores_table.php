<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('store_name');
            $table->text('store_description');
            $table->string('phone');
            $table->string('phone_whatsapp')->nullable();
            $table->string('url_facebook')->nullable();
            $table->string('url_instegram')->nullable();
            $table->string('street');
            $table->foreignId('city_id')->constrained('cities');
            $table->string('location_latitude');
            $table->string('location_longitude');
            $table->boolean('state');
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
        Schema::dropIfExists('stores');
    }
};
