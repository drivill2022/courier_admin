<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('slid',100);
            $table->string('name',255);
            $table->string('email',128)->unique()->nullable();
            $table->string('password');
            $table->string('mobile',100)->unique();
            $table->string('picture')->nullable();
            $table->string('nid_no',150);
            $table->string('business_name',255);
            $table->string('business_logo')->nullable();
            $table->string('fb_page')->nullable();
            $table->mediumText('address')->nullable();
            $table->float('latitude', 15, 8)->nullable();
            $table->float('longitude', 15, 8)->nullable();
            $table->bigInteger('thana')->nullable();
            $table->bigInteger('district')->nullable();
            $table->bigInteger('division')->nullable();
            $table->enum('status', ['Active', 'Blocked']);
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
        Schema::dropIfExists('sellers');
    }
}
