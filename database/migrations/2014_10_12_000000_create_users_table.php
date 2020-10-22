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
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('birthday')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->unsignedBigInteger('level_id')->nullable();
            $table->timestamp('level_updated_at')->nullable();
            $table->string('password');
            $table->string('gender')->nullable();
            $table->string('avatar')->nullable();
            $table->string('cover_photo')->nullable();
            $table->text('bio')->nullable();
            $table->string('school_name')->nullable();
            $table->unsignedBigInteger('governorate_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->boolean('banned')->nullable()->default(false);
            $table->string('locale', 4)->nullable()->default('en');
            $table->text('fcm_token')->nullable();
            $table->boolean('notification_toggle')->nullable()->default(true);
            $table->string('os_type')->nullable();
            $table->string('last_session_id')->nullable();
            $table->string('last_ip')->nullable();
            $table->enum('type',['ADMIN','TEACHER','USER'])->default('USER');
            $table->integer('wallet')->default(0);//users
            $table->integer('debit')->default(0);//teachers
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
