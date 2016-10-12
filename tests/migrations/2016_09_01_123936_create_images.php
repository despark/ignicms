<?php


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            /*
             * CREATE TABLE `images` (
             * `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
             * `resource_id` int(11) NOT NULL,
             * `resource_model` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
             * `image_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
             * `original_image` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
             * `retina_factor` smallint(5) unsigned DEFAULT NULL,
             * `order` smallint(6) NOT NULL DEFAULT '0',
             * `meta` text COLLATE utf8_unicode_ci,
             * `created_at` timestamp NULL DEFAULT NULL,
             * `updated_at` timestamp NULL DEFAULT NULL,
             * PRIMARY KEY (`id`)
             * ) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
             */
            $table->increments('id');
            $table->unsignedInteger('resource_id');
            $table->string('resource_model', 45);
            $table->string('image_type', 100);
            $table->string('original_image', 100);
            $table->unsignedSmallInteger('retina_factor');
            $table->smallInteger('order')->default(0);
            $table->string('alt');
            $table->string('title');
            $table->json('meta');
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('images');
    }
}
