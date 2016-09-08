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
        // php artisan db:seed --class="PermissionRoleTableSeeder"
        $permissions = Permission::all();
        $adminRole = Role::whereName('admin')->first();

        foreach ($permissions as $permission) {
            if (! $adminRole->hasPermissionTo($permission)) {
                $adminRole->givePermissionTo($permission->name);
            }
        }
        $rolePermissions = ['manage_pages', 'access_admin'];

        /** @var Role $editorRole */
        $editorRole = Role::whereName('editor')->first();
        foreach ($rolePermissions as $permission) {
            if (! $editorRole->hasPermissionTo($permission)) {
                $editorRole->givePermissionTo($permission);
            }
        }
    }
}
