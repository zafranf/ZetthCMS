<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('title')->index();
            $table->string('slug')->index();
            $table->longText('content');
            $table->text('excerpt')->nullable();
            $table->string('cover');
            $table->enum('type', ['article', 'page', 'video'])->default('article');
            $table->boolean('share');
            $table->boolean('like');
            $table->boolean('comment');
            $table->integer('visited')->unsigned();
            $table->integer('shared')->unsigned();
            $table->integer('liked')->unsigned();
            $table->dateTime('time');
            $table->string('short_url');
            $table->boolean('status')->comment('0=pending, 1=active, 2=draft')->unsigned();
            $table->integer('created_by')->unsigned()->index();
            $table->integer('updated_by')->unsigned();
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
        Schema::dropIfExists('posts');
    }
}
