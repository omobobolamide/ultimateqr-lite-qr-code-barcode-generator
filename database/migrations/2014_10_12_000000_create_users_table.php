<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->increments('id')->uniqid();
            $table->string('name');
            $table->string('email')->unique();
            $table->bigInteger('role_id')->default(1);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('auth_type')->nullable();
            $table->string('choosed_theme')->default('light');
            $table->longText('profile_image')->nullable();
            $table->integer('status')->default(1);
            $table->rememberToken();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
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
