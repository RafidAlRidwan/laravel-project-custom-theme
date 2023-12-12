<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        try {
            $admin = User::create([
                'name' => 'Developer',
                'email' => 'platform.singularity@gmail.com',
                'password' => Hash::make('12345678'),
            ]);

            $adminRole = Role::create(['name' => 'Admin']);
            // $adminRole = Role::create(['name' => 'User']);
            $permissionsData = [
                ['name' => 'user_list', 'guard_name' => 'web'],
                ['name' => 'user_create', 'guard_name' => 'web'],
                ['name' => 'user_edit', 'guard_name' => 'web'],
                ['name' => 'user_delete', 'guard_name' => 'web'],
                ['name' => 'permission_list', 'guard_name' => 'web'],
                ['name' => 'permission_edit', 'guard_name' => 'web'],
                ['name' => 'permission_create', 'guard_name' => 'web'],
                ['name' => 'permission_delete', 'guard_name' => 'web'],
                ['name' => 'role_list', 'guard_name' => 'web'],
                ['name' => 'role_create', 'guard_name' => 'web'],
                ['name' => 'role_edit', 'guard_name' => 'web'],
                ['name' => 'role_delete', 'guard_name' => 'web'],
            ];
            foreach ($permissionsData as $permission) {
                DB::table('permissions')->insert($permission);
            }

            $adminRole->givePermissionTo([
                'user_list',
                'user_edit',
                'user_create',
                'user_delete',
                'permission_list',
                'permission_edit',
                'permission_create',
                'permission_delete',
                'role_list',
                'role_edit',
                'role_create',
                'role_delete',
            ]);

            $admin->assignRole('Admin');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
