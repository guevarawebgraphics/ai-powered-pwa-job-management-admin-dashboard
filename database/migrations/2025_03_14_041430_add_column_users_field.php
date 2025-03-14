<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnUsersField extends Migration
{
 /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('status');
            $table->string('user_name', 45)/*->unique()*/;
            $table->string('first_name', 25);
            $table->string('middle_name', 25);
            $table->string('last_name', 25);
            $table->string('phone', 250);
            $table->string('token', 255)->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->timestamp('last_login')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'token',
                'status',
                'user_name', 
                'first_name',
                'middle_name',
                'last_name',
                'phone', 
                'is_active',
                'last_login'
            ]);
        });
    }
}
