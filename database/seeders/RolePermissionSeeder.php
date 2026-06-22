<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['admin', 'staff', 'waspang'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        $permissions = [
            'manage users',
            'manage projects',
            'manage waspang',
            'manage lokasi',
            'approve project',
            'reject project',
            'view dashboard',
            'generate document',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        $admin = Role::where('name', 'admin')->first();
        if ($admin) {
            $admin->syncPermissions(Permission::all());
        }

        $staff = Role::where('name', 'staff')->first();
        if ($staff) {
            $staff->syncPermissions([
                'manage projects',
                'view dashboard',
                'generate document',
            ]);
        }

        $waspang = Role::where('name', 'waspang')->first();
        if ($waspang) {
            $waspang->syncPermissions([
                'approve project',
                'reject project',
                'view dashboard',
            ]);
        }

        $adminUser = User::firstOrCreate(
            ['email' => 'admin@telkom.co.id'],
            ['name' => 'Admin', 'password' => bcrypt('password')]
        );
        if ($adminUser && $admin) {
            $adminUser->assignRole('admin');
        }

        $staffUser = User::firstOrCreate(
            ['email' => 'staff@telkom.co.id'],
            ['name' => 'Staff', 'password' => bcrypt('password')]
        );
        if ($staffUser && $staff) {
            $staffUser->assignRole('staff');
        }

        $waspangUser = User::firstOrCreate(
            ['email' => 'waspang@telkom.co.id'],
            ['name' => 'Waspang', 'password' => bcrypt('password')]
        );
        if ($waspangUser && $waspang) {
            $waspangUser->assignRole('waspang');
        }
    }
}
