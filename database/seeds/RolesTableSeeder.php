<?php

use Illuminate\Database\Seeder;
use Despark\Cms\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // php artisan db:seed --class="RolesTableSeeder"
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Admin',
                'description' => 'Administrator of the website. Can modify all content.',
            ],
            [
                'name' => 'editor',
                'display_name' => 'Editor',
                'description' => 'Administrator of the website. Can modify all content.',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
