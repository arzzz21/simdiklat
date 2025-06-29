<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run(): void
    // {
    //     //
    // }
    public function run()
    {
        // Buat role
        $admin = Role::create(['name' => 'admin']);
        $dosen = Role::create(['name' => 'dosen']);

        // Buat permission opsional
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'view dashboard']);

        // Berikan permission ke role
        $admin->givePermissionTo(['manage users', 'view dashboard']);
        $dosen->givePermissionTo(['view dashboard']);

        // Assign role ke user pertama (sebagai admin)
        $user = User::first();
        $user->assignRole('admin');
    }
}
