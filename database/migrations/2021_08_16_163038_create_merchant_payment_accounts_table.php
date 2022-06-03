<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantPaymentAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_payment_accounts', function (Blueprint $table) {
            $table->id();
            $table->enum('payment_mode',[0,1,2,3])->comment('0 for Nagad,1 for Bank Deposit,2 for Cash,3 for Bkash');
            $table->unsignedBigInteger('shipment_id');
            $table->string('txn_id');
            $table->unsignedBigInteger('merchant_id');
            $table->foreign('merchant_id')->references('id')->on('merchants');
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
