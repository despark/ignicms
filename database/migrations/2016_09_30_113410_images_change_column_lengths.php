<?php

use Illuminate\Database\Migrations\Migration;

class ImagesChangeColumnLengths extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement('ALTER TABLE `images`
MODIFY COLUMN `resource_model`  VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `resource_id`,
MODIFY COLUMN `image_type`  VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `resource_model`,
MODIFY COLUMN `original_image`  VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `image_type`;
');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('ALTER TABLE `images`
MODIFY COLUMN `resource_model`  VARCHAR(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `resource_id`,
MODIFY COLUMN `image_type`  VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `resource_model`,
MODIFY COLUMN `original_image`  VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL AFTER `image_type`;
');
    }
}
