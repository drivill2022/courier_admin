<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryRidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_riders', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->unsignedBigInteger('hub_id');
            $table->foreign('hub_id')->references('id')->on('hubs');
            $table->string('mobile',100)->unique();
            $table->string('email',128)->unique()->nullable();
            $table->string('password');
            $table->mediumInteger('otp')->length(6)->unsigned()->nullable();
            $table->enum('gender',['male','female', 'other'])->nullable();
            $table->string('picture')->nullable();
            $table->string('nid_number')->nullable();
            $table->string('nid_picture')->nullable();
            $table->string('father_nid')->nullable();
            $table->string('father_nid_pic')->nullable();
            $table->string('referral_code')->nullable();
            $table->string('referral_by')->nullable();
            $table->mediumText('address')->nullable();
            $table->float('latitude', 15, 8)->nullable();
            $table->float('longitude', 15, 8)->nullable();
            $table->bigInteger('thana')->nullable();
            $table->bigInteger('district')->nullable();
            $table->bigInteger('division')->nullable();
            $table->unsignedBigInteger('vehicle_type_id');
            $table->foreign('vehicle_type_id')->references('id')->on('vehicle_types');
            $table->enum('status', ['Active','Onboarding', 'Blocked']);
            $table->timestamp('email_verified_at')->nullable();
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
        Schema::dropIfExists('delivery_riders');
    }
}
