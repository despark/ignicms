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
            [
                'name' => 'access_admin',
            ],
        ];

        // Only add new
        $allPermissions = Permission::all()->pluck('name')->toArray();

        foreach ($permissions as $permission) {
            if (! in_array($permission, $allPermissions)) {
                Permission::create($permission);
            }
        }
    }
}
