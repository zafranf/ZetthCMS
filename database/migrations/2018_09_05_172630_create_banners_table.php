<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title');
			$table->string('description')->nullable();
			$table->string('image');
			$table->string('url');
			$table->boolean('url_external')->comment('0=false, 1=true');
            $table->enum('target', ['_self', '_blank'])->default('_self');
			$table->tinyInteger('order')->default(1);
			$table->boolean('only_image')->comment('0=false, 1=true');
			$table->boolean('status')->comment('0=inactive, 1=active')->unsigned();
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
        Schema::dropIfExists('banners');
    }
}
