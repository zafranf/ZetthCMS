<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntermDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interm_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('host')->index();
            $table->string('text');
            $table->integer('count');
            $table->integer('post_id')->unsigned()->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interm_datas');
    }
}
