<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('site')->nullable();
            $table->longText('comment');
            $table->boolean('read')->comment('0=unread, 1=read');
            $table->boolean('status')->comment('0=pending, 1=active')->unsigned();
            $table->integer('parent_id')->unsigned()->index();
            $table->integer('post_id')->unsigned()->index();
            $table->integer('approved_by')->unsigned();
            $table->integer('created_by')->unsigned();
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
        Schema::dropIfExists('post_comments');
    }
}
