<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DesparkDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('permission_role')->truncate();
        DB::table('role_user')->truncate();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();
        DB::table('users')->truncate();
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(PermissionRoleTableSeeder::class);
        $this->call(RoleUserTableSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Model::reguard();
    }
}
