<?php

use Illuminate\Database\Seeder;
use Despark\Models\Permission;

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
                'display_name' => 'Manage users',
                'description' => 'Edit/update/add/delete users (team members)',
            ],
            [
                'name' => 'manage_pages',
                'display_name' => 'Manage pages',
                'description' => 'Edit/update/add/delete pages',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
