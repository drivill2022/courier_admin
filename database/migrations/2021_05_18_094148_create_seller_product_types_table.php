<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerProductTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seller_product_types', function (Blueprint $table) {
           $table->unsignedBigInteger('seller_id')->index('product_type_seller_seller_id_foreign');
           $table->unsignedBigInteger('product_type_id');
           $table->primary(['product_type_id','seller_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seller_product_types');
    }
}
