<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('merchants', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('name',255);
            $table->string('mobile',100)->unique();
            $table->string('email',128)->unique();
            $table->string('password');
            $table->string('picture')->nullable();
            $table->string('mrid',100);
            $table->integer('otp')->default(0);
            $table->string('business_logo')->nullable();
            $table->string('nid_number')->nullable();
            $table->string('product_type')->nullable();
            $table->string('buss_name')->nullable();
            $table->string('buss_phone')->nullable();
            $table->string('buss_address')->nullable();
            $table->string('trade_lic_no')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('fb_page')->nullable();
            $table->mediumText('address')->nullable();
            $table->bigInteger('thana')->nullable();
            $table->bigInteger('district')->nullable();
            $table->bigInteger('division')->nullable();
            $table->enum('status', ['Active', 'Blocked','Onboarding']);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('merchants');
    }
}
