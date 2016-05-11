<?php

use Illuminate\Database\Seeder;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $adminId = DB::table('users')
            ->where('email', 'admin@despark.com')
            ->value('id');

        $adminRoleId = DB::table('roles')
            ->where('name', 'admin')
            ->value('id');

        if ($adminId and $adminRoleId) {
            DB::table('role_user')
                ->insert([
                    'user_id' => $adminId,
                    'role_id' => $adminRoleId,
                ]);
        }
    }
}
