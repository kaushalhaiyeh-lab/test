<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        if (User::where('email', env('SUPER_ADMIN_EMAIL'))->exists()) {
            return;
        }

        $user = User::create([
            'name' => env('SUPER_ADMIN_NAME', 'Super Admin'),
            'email' => env('SUPER_ADMIN_EMAIL'),
            'password' => Hash::make(env('SUPER_ADMIN_PASSWORD')),
        ]);

        $role = Role::firstOrCreate(['name' => 'super_admin']);

        $user->assignRole($role);
    }
}
