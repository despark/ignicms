# Despark's igniCMS
## IMPORTANT: This repo has been moved to https://github.com/despark/igni-core. 
For laravel 5.4+ please use the new repo. Thanks!

## Introduction
**igniCMS** is an administrative interface builder for Laravel 5.3

For Laravel versions 5.2 use branch v2.0

## Prerequisites

 - nodejs >= 4.0
 - npm
 - bower
 - gulp
 - composer

## Installation

1. Require this package in your composer.json and run `composer update`:

  ```json
  "require": {
     "php": ">=5.5.9",
     "laravel/framework": "5.1.*",
     "despark/ignicms": "dev-master"
  },
  ```

  Or `composer require despark/ignicms`

2. After composer update, insert service providers `Despark\Providers\AdminServiceProvider::class,` `Despark\Cms\Providers\FieldServiceProvider::class,` before the _application service providers_ to the `config/app.php`

  **Example**

  ```php
   ...
   /*
    * Despark CMS Service Provider
    */
     Despark\Cms\Providers\AdminServiceProvider::class,
     Despark\Cms\Providers\FieldServiceProvider::class,

   /*
    * Application Service Providers...
    */
     App\Providers\AppServiceProvider::class,
   ...
  ```

3. Run this command in the terminal (it'll set all necessary resources to use the CMS. _To complete this step you should have **composer**, **npm** & **bower**, installed globally_):

  ```
    php artisan igni:admin:install
  ```

4. Run the database seeder to populate the database with default user, permissions and roles:

  ```
    php artisan db:seed --class=DesparkDatabaseSeeder
  ```

5. All done! Now go to the `<your_site_url>/admin` and use default credentials `admin@despark.com` / `Despark1234`

## Additional commands

- Use the command `php artisan igni:admin:resource` to create all necessary files for manipulating resources. You should specify the resource name (in title case).

  **Example**

  ```
    php artisan igni:admin:resource "Blog Post"
  ```

- The command `php artisan igni:admin:update` will update composer dependencies, it'll clear the autoload and it'll run any new migrations.

- You can run `php artisan igni:admin:prod` on your production server, after deploy. It will install all dependencies according to your composer.lock file, run new migrations and optimize the autoload.

### Image styles rebuilding ###
You can rebuild image styles using `php artisan igni:images:rebuild` . If you want you can specify which resources to rebuil with `--resources=*` switch.
You can exclude some resources with `--without=*`

## Copyright and License

Despark CMS was written by Despark for the Laravel framework and is released under the MIT License. See the LICENSE file for details.
