<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnGigCustomerInput extends Migration
{
       /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gigs', function (Blueprint $table) {
            $table->longtext('customer_input')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gigs', function (Blueprint $table) {
            $table->dropColumn([
                'customer_input',
            ]);
        });
    }

}
