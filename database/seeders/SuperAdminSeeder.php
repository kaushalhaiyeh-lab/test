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
        $email = env('SUPER_ADMIN_EMAIL');

        // If env vars are missing, do nothing (prevents crash)
        if (! $email) {
            return;
        }

        if (User::where('email', $email)->exists()) {
            return;
        }

        $user = User::create([
            'name' => env('SUPER_ADMIN_NAME', 'Super Admin'),
            'email' => $email,
            'password' => Hash::make(env('SUPER_ADMIN_PASSWORD', 'password')),
        ]);

        $role = Role::firstOrCreate(['name' => 'super_admin']);
        $user->assignRole($role);
    }
}
