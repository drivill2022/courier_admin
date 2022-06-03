<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiderPaymentAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rider_payment_accounts', function (Blueprint $table) {
            $table->id();
            $table->enum('payment_mode',[0,1])->comment('0 for cash,1 for card');
            $table->unsignedBigInteger('shipment_id');
            $table->string('txn_id');
            $table->unsignedBigInteger('rider_id');
            $table->foreign('rider_id')->references('id')->on('delivery_riders');
            $table->string('pay_amount');
            $table->enum('status',[0,1])->comment('0 for pending, 1 for done');
            $table->unsignedBigInteger('paid_by');
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
        Schema::dropIfExists('merchant_payment_accounts');
    }
}
