<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Create Permissions
        |--------------------------------------------------------------------------
        */
        $permissions = [
            'admin.access',

            'project.view',
            'project.create',
            'project.update',
            'project.delete',
            'project.assign-user',

            'task.update-status',

            'payments.manage',
            'payment.view',

            'user.access',

            'clients.manage'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        /*
        |--------------------------------------------------------------------------
        | 2. Create Roles
        |--------------------------------------------------------------------------
        */
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
        $roleUser = Role::firstOrCreate(['name' => 'user']);

        /*
        |--------------------------------------------------------------------------
        | 3. Assign permissions to roles
        |--------------------------------------------------------------------------
        */

        // Admin gets everything
        $roleAdmin->givePermissionTo(Permission::all());

        $roleUser->givePermissionTo([
            'project.view',
        ]);

        /*
        |--------------------------------------------------------------------------
        | 4. Create Users
        |--------------------------------------------------------------------------
        */

        // Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
        ]);

        // Normal User
        $normalUser = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('user123'),
        ]);

        /*
        |--------------------------------------------------------------------------
        | 5. Assign Roles to Users
        |--------------------------------------------------------------------------
        */
        $admin->assignRole($roleAdmin);
        $normalUser->assignRole($roleUser);
    }
}
