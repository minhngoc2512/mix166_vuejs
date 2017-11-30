<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('path');
            $table->string('thumbnail');
            $table->string('status');
            $table->integer('user_create_id');
            $table->integer('user_publish_id');
            $table->integer('category_id');
            $table->integer('genre_id');
            $table->integer('artist_id');
            $table->string('type');
            $table->integer('file_view')->default(0);
            $table->timestamp('published_at');
            $table->softDeletes();
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
        Schema::dropIfExists('files');
    }
}
