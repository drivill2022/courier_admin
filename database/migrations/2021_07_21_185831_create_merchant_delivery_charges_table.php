<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantDeliveryChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_delivery_charges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('merchant_id');
            $table->foreign('merchant_id')->references('id')->on('merchants');
            $table->mediumInteger('product_type')->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->string('gm_500')->nullable();
            $table->string('kg_1')->nullable();
            $table->string('kg_2')->nullable();
            $table->string('kg_3')->nullable();
            $table->string('kg_4')->nullable();
            $table->string('kg_5')->nullable();
            $table->string('kg_6')->nullable();
            $table->string('kg_7')->nullable();
            $table->string('kg_upto_seven')->nullable();
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
        Schema::dropIfExists('merchant_delivery_charges');
    }
}
