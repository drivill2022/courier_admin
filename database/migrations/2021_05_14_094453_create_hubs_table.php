<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hubs', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('name',255);
            $table->string('picture')->nullable();
            $table->string('email',128)->unique()->nullable();
            $table->string('password');
            $table->string('phone',100)->unique();
            $table->mediumText('address')->nullable();
            $table->float('latitude', 15, 8)->nullable();
            $table->float('longitude', 15, 8)->nullable();
            $table->string('hbsid',100)->nullable();
            $table->bigInteger('thana')->nullable();
            $table->bigInteger('district')->nullable();
            $table->bigInteger('division')->nullable();
            $table->string('supervisor_name',255);
            $table->string('sup_phone',100)->unique();;
            $table->string('sup_picture');
            $table->string('sup_tin_no');
            $table->string('sup_nid_no');
            $table->string('sup_nid_pic')->nullable();
            $table->string('sup_tin_pic')->nullable();
            $table->string('tl_picture')->nullable();
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
        Schema::dropIfExists('hubs');
    }
}
