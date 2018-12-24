<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('email')->unique();
            $table->string('name')->unique();
            $table->string('fullname');
            $table->string('password');
            $table->string('language')->default('id');
            $table->text('biography')->nullable();
            $table->string('image')->nullable();
            $table->string('timezone')->default('Asia/Jakarta');
            // $table->integer('role_id')->unsigned();
            $table->dateTime('login_last')->nullable();
            $table->boolean('login_failed')->unsigned()->default(0);
            $table->boolean('is_admin')->comment('0=no, 1=yes')->unsigned()->default(1);
            $table->boolean('status')->comment('0=inactive, 1=active')->unsigned();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
