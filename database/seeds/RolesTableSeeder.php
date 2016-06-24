<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

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
            ],
            [
                'name' => 'editor',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
