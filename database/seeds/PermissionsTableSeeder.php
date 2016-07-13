<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // php artisan db:seed --class="PermissionsTableSeeder"
        $permissions = [
            [
                'name' => 'manage_users',
            ],
            [
                'name' => 'manage_pages',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
