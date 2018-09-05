<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitorLogDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitor_log_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('browser');
            $table->string('browser_agent');
            $table->string('referral')->nullable();
            $table->string('page');
            $table->string('device');
            $table->string('device_name');
            $table->bigInteger('count');
            $table->bigInteger('visitor_id');
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
        Schema::dropIfExists('visitor_log_details');
    }
}
