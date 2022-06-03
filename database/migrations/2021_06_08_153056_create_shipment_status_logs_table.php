<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipmentStatusLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipment_status_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shipment_id');
            $table->foreign('shipment_id')->references('id')->on('shipments');
            $table->enum('status', [1,2,3,4,5,6]);
            $table->string('reason')->nullable();
            $table->string('cash_status')->nullable();
            $table->mediumText('note')->nullable();
            $table->enum('updated_by',['Admin','Merchant','Hub','Rider','Seller','Customer'])->nullable();
            $table->unsignedBigInteger('updated_by_id')->nullable();
            $table->string('updated_ip')->nullable();
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
        Schema::dropIfExists('shipment_status_logs');
    }
}
