<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('shipment_no',150)->unique()->nullable();
            $table->unsignedBigInteger('merchant_id');
            $table->foreign('merchant_id')->references('id')->on('merchants');
            $table->string('receiver_name',255);
            $table->string('contact_no',100);
            $table->string('product_detail',255);
            $table->string('product_weight')->nullable();
            $table->string('product_type')->nullable();
            $table->string('note')->nullable();
            $table->mediumText('s_address');
            $table->mediumText('d_address');
            $table->bigInteger('s_district')->nullable();
            $table->bigInteger('s_thana')->nullable();
            $table->bigInteger('s_division')->nullable();
            $table->bigInteger('d_district')->nullable();
            $table->bigInteger('d_thana')->nullable();
            $table->bigInteger('d_division')->nullable();
            $table->float('s_latitude', 15, 8)->nullable();
            $table->float('s_longitude', 15, 8)->nullable();
            $table->float('d_latitude', 15, 8)->nullable();
            $table->float('d_longitude', 15, 8)->nullable();
            $table->mediumInteger('shipment_type')->nullable();
            $table->double('shipment_cost',12,2)->nullable();
            $table->tinyInteger('status');
            $table->timestamp('pickup_date')->nullable();
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
        Schema::dropIfExists('shipments');
    }
}
