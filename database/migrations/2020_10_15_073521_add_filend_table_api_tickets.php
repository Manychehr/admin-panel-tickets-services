<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFilendTableApiTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('api_tickets', function (Blueprint $table) {
            $table->string('limit_time')->nullable();
            $table->integer('limit_import')->nullable();
            $table->integer('current_page')->nullable();
            $table->integer('cron')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('api_tickets', function (Blueprint $table) {
            //
        });
    }
}
