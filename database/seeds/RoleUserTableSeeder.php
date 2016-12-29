<?php

use App\Models\User;
use Illuminate\Database\Seeder;

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
