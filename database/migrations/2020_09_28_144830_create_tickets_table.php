<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('api_id');
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('author_id')->nullable();
            $table->boolean('in_scheme')->default(false);
            $table->boolean('show')->default(true);
            $table->json('data')->nullable();
            $table->timestamps();

            // $table->foreign('service_id')->references('id')->on('api_tickets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
