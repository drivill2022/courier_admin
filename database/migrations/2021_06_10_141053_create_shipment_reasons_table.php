<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipmentReasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipment_reasons', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->mediumInteger('reason_for')->comment('0=All,1=Admin,2=rider,3=hub,4=merchant,5=seller,6=customers');

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
        Schema::dropIfExists('shipment_reasons');
    }
}
