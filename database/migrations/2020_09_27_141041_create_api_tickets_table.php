<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('service');
            $table->string('subdomain')->nullable();
            $table->string('api_key');
            $table->string('secret_key')->nullable();
            $table->string('url')->nullable();
            
            /* $table->string('limit_time')->nullable();
            $table->integer('limit_import')->nullable();
            $table->integer('current_page')->nullable();
            $table->integer('cron')->nullable(); */
            
            $table->timestamp('import_at')->nullable();
            $table->timestamp('update_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_tickets');
    }
}
