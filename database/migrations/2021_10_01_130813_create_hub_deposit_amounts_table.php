<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHubDepositAmountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hub_deposit_amounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shipment_id')->default(0);
            $table->unsignedBigInteger('hub_id');
            //$table->foreign('rider_id')->references('id')->on('delivery_riders');
            $table->float('amount', 10, 2);
            $table->enum('status',[0,1])->comment('0 for disapprove, 1 for approved');
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
        Schema::dropIfExists('hub_deposit_amounts');
    }
}
