<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiderVehicleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rider_vehicle_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('delivery_rider_id');
            $table->foreign('delivery_rider_id')->references('id')->on('delivery_riders');
            $table->string('dl_photo');
            $table->string('dl_number');
            $table->string('brand');
            $table->string('model');
            $table->string('region');
            $table->string('category');
            $table->string('plat_number');
            $table->string('token_number');
            $table->string('rc_photo');
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
        Schema::dropIfExists('rider_vehicle_details');
    }
}
