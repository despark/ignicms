<?php

use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $permissionRoles = [];
        $adminRoleId = DB::table('roles')
            ->where('name', 'admin')
            ->value('id');

        $editorRoleId = DB::table('roles')
            ->where('name', 'editor')
            ->value('id');
        $pagesPermId = DB::table('permissions')
            ->where('name', 'manage_pages')
            ->value('id');

        if ($adminRoleId) {
            $allPermissions = DB::table('permissions')
                ->get();

            foreach ($allPermissions as $permission) {
                $permissionRoles[] = [
                    'permission_id' => $permission->id,
                    'role_id' => $adminRoleId,
                ];
            }
        }

        if ($editorRoleId && $pagesPermId) {
            $permissionRoles[] = [
                'permission_id' => $pagesPermId,
                'role_id' => $editorRoleId,
            ];
        }

        DB::table('permission_role')
            ->insert($permissionRoles);
    }
}
