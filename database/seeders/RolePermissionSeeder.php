<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'manage_users',
            'manage_roles',
            'manage_jobs',
            'manage_pages',
            'manage_services',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $hr = Role::firstOrCreate(['name' => 'hr']);

        $superAdmin->givePermissionTo(Permission::all());

        $admin->givePermissionTo([
            'manage_jobs',
            'manage_pages',
            'manage_services',
        ]);

        $hr->givePermissionTo([
            'manage_jobs',
        ]);

        $user = User::where('email', 'kaushalsheth12@gmail.com')->first();
        if ($user) {
            $user->assignRole('super_admin');
        }
    }
}
