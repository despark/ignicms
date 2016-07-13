<?php

use Illuminate\Database\Seeder;
use Despark\Cms\Models\User;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $adminUser = User::where('email', 'LIKE', 'admin%')->first();

        $adminUser->assignRole('admin');
    }
}
