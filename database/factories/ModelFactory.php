<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Despark\Cms\Models\Image::class, function (Faker\Generator $faker) {
    /**
     * `resource_id` int(11) NOT NULL,
     * `resource_model` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
     * `image_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
     * `original_image` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
     * `retina_factor` smallint(5) unsigned DEFAULT NULL,
     * `order` smallint(6) NOT NULL DEFAULT '0',
     * `alt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
     * `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
     * `meta` text COLLATE utf8_unicode_ci,
     */
    return [
        'resource_id' => 0,
        'resource_model' => '\Test\Class',
        'image_type' => 'test',
        'original_image' => $faker->image('/tmp', 640, 480, 'cats', false),
        'retina_factor' => rand(1, 4),
        'order' => 0,
        'alt' => 'Alt',
        'title' => 'title',
        'meta' => ['testing' => 1],
    ];
});

$factory->define(\Despark\Cms\Models\File\Temp::class, function (Faker\Generator $faker) {
    /*
     * `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
     * `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
     * `temp_filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
     * `file_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
     * `created_at` timestamp NULL DEFAULT NULL,
     * `updated_at` timestamp NULL DEFAULT NULL,
     */
    $image = $faker->image(\Despark\Cms\Models\File\Temp::getTempDirectory(), 10, 10, 'cats', false);

    return [
        'filename' => $faker->name,
        'temp_filename' => $image,
        'file_type' => $faker->mimeType,
    ];
});
$factory->define(\Despark\Cms\Models\Video::class, function (Faker\Generator $faker) {
    /*
     * `resource_id` int(10) unsigned NOT NULL,
     * `resource_model` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
     * `field` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
     * `provider` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
     * `video_id` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
     * `config` json NOT NULL,
     */
    return [
        'resource_id' => 0,
        'resource_model' => 0,
        'field' => 'field',
        'provider' => 'youtube',
        'video_id' => 'C0DPdy98e4c',
        'config' => ['width' => 300, 'height' => 150],
    ];
});

$factory->define(\Despark\Tests\Cms\Resources\TestResourceModel::class, function (Faker\Generator $faker) {
    return [
        'test_field' => $faker->word,
    ];
});