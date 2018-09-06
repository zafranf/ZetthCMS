<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('url')->nullable();
            $table->boolean('menu_url_external')->comment('0=false, 1=true')->default(0);
            $table->string('route_name')->nullable();
            $table->string('icon')->nullable();
            $table->enum('target', ['_self', '_blank'])->default('_self');
            $table->enum('group', ['admin', 'web'])->default('admin');
            $table->tinyInteger('order')->unsigned()->default(1)->nullable();
            $table->boolean('status')->comment('0=inactive, 1=active')->unsigned();
            $table->integer('parent_id')->unsigned()->default(0)->nullable();
            $table->boolean('index')->unsigned()->default(0)->nullable();
            $table->boolean('create')->unsigned()->default(0)->nullable();
            $table->boolean('read')->unsigned()->default(0)->nullable();
            $table->boolean('update')->unsigned()->default(0)->nullable();
            $table->boolean('delete')->unsigned()->default(0)->nullable();
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
        Schema::dropIfExists('menus');
    }
}
