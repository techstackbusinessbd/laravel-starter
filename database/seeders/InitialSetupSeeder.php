<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InitialSetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['Super Admin', 'Admin', 'Officer', 'Customer'];

        // Step 1: Create all permissions first
        $permissions = [
        'user.create',
        'user.edit',
        'user.delete',
        'user.view',
        'role.create',
        'role.edit',
        'role.delete',
        'role.view',
        ];

        foreach ($permissions as $permission) {
        Permission::firstOrCreate(['name' => $permission]);
        }

        // Step 2: Create all roles
        foreach ($roles as $roleName) {
        $role = Role::firstOrCreate(['name' => $roleName]);

        if($roleName === 'Super Admin') {
        // Now permissions exist, assign all to Super Admin
        $role->syncPermissions(Permission::all());
        }
        }

        // Step 3: Create Super Admin user
        $superAdmin = User::firstOrCreate(
        ['email' => 'superadmin@abc.com'],
        [
        'name' => 'Super Admin',
        'password' => Hash::make('11111111'), // Change in production
        ]
        );

        // Step 4: Assign Super Admin role
        $superAdmin->assignRole('Super Admin');
    }
}
