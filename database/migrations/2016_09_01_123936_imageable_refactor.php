<?php


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ImageableRefactor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('imageables', 'images');

        Schema::table('images', function (Blueprint $table) {
            /**
             * `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
             * `imageable_id` int(11) NOT NULL,
             * `imageable_type` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
             * `file` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
             * `orientation` int(11) NOT NULL,
             * `created_at` timestamp NULL DEFAULT NULL,
             * `updated_at` timestamp NULL DEFAULT NULL,
             */
            $table->renameColumn('imageable_id', 'resource_id');
            $table->renameColumn('imageable_type', 'resource_model');
            $table->string('image_type', 100)->after('imageable_type');
            $table->renameColumn('file', 'original_image');
            $table->unsignedSmallInteger('retina_factor')->nullable()->after('file');

            $table->dropColumn('orientation');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('images', 'imageables');

        Schema::table('imageables', function (Blueprint $table) {
            $table->renameColumn('resource_id', 'imageable_id');
            $table->renameColumn('resource_model', 'imageable_type');
            $table->renameColumn('original_image', 'file');
            $table->dropColumn('retina_factor');
            $table->dropColumn('image_type');
            $table->integer('orientation')->after('original_image');

        });
    }
}
