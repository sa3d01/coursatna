<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_sessions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("topic")->nullable();
            $table->string("uploader_id")->nullable();
            $table->string("course_id")->nullable();
            //test videos
            $table->boolean('open')->default(0);
            //mp4,...
            $table->string('file_type')->nullable();
            //first.mp4
            $table->string('file')->nullable();
            //https://www.youtube.com/watch?v=fxXGLMPJnFQ
            $table->string('external_url')->nullable();
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('course_sessions');
    }
}
