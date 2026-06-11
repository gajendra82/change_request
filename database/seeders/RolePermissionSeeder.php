<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'manage clients',
            'manage users',
            'manage projects',
            'manage change requests',
            'approve timeline',
            'reject timeline',
            'view reports',
            'add timeline',
            'update progress',
            'create change request',
            'view own requests',
            'comment',
            'download attachments',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->syncPermissions(Permission::all());

        $manager = Role::firstOrCreate(['name' => 'manager', 'guard_name' => 'web']);
        $manager->syncPermissions(['approve timeline', 'reject timeline', 'view reports']);

        $developer = Role::firstOrCreate(['name' => 'developer', 'guard_name' => 'web']);
        $developer->syncPermissions(['add timeline', 'update progress', 'view own requests']);

        $client = Role::firstOrCreate(['name' => 'client', 'guard_name' => 'web']);
        $client->syncPermissions(['create change request', 'view own requests', 'comment', 'download attachments']);
    }
}
