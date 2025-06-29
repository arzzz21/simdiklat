<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UserRolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Role
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $dosenRole = Role::firstOrCreate(['name' => 'dosen']);

        // (Opsional) Buat Permission
        $permissions = ['manage users', 'view dashboard'];
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Assign permission ke role
        $adminRole->givePermissionTo($permissions);
        $dosenRole->givePermissionTo('view dashboard');

        // Buat user admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin Utama',
                'password' => Hash::make('password'), // Ganti password sesuai kebutuhan
            ]
        );
        $admin->assignRole($adminRole);

        // Buat user dosen
        $dosen = User::firstOrCreate(
            ['email' => 'dosen@example.com'],
            [
                'name' => 'Dosen Pertama',
                'password' => Hash::make('password'), // Ganti password sesuai kebutuhan
            ]
        );
        $dosen->assignRole($dosenRole);

        $this->command->info('Seeder selesai: user admin & dosen dibuat.');
    }
}
