<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeoPagesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('seo_pages', function (Blueprint $table) {
            $table->increments('id');

            $table->string('page_title', 100);
            $table->string('page_slug', 100);
            $table->string('meta_title', 100);
            $table->string('meta_description', 200);
            $table->string('meta_image');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('seo_pages');
    }
}
