<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeoPagesRemoveMetaImage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seo_pages', function (Blueprint $table) {
            $table->dropColumn('meta_image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seo_pages', function (Blueprint $table) {
            $table->string('meta_image')->after('meta_description');
        });
    }
}
