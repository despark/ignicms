<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $permissions = Permission::all();
        $adminRole = Role::whereName('admin')->first();

        foreach ($permissions as $permission) {
            $adminRole->givePermissionTo($permission->name);
        }

        $editorRole = Role::whereName('editor')->first();
        $editorRole->givePermissionTo('manage_pages');
    }
}
