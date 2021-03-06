<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddForeignKeyToDriPermissionsRolesTable extends Migration
{
        /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permission_roles', function(Blueprint $table)
        {
            $table->foreign('permission_id', 'permission_roles_permission_id_foreign')->references('id')->on('permissions')->onUpdate('RESTRICT')->onDelete('CASCADE');

            $table->foreign('role_id', 'permission_roles_role_id_foreign')->references('id')->on('roles')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permission_roles', function(Blueprint $table)
        {
            $table->dropForeign('permission_roles_permission_id_foreign');

            $table->dropForeign('permission_roles_role_id_foreign');
        });
    }
}
