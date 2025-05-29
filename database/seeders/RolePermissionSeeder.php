<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = ['create_post', 'edit_post', 'delete_post', 'view_post'];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Create Roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $editor = Role::firstOrCreate(['name' => 'client']);
        $editor = Role::firstOrCreate(['name' => 'user']);

        // Attach Permissions
        $admin->permissions()->sync(Permission::all()->pluck('id'));
        $editor->permissions()->sync(
            Permission::whereIn('name', ['create_post', 'edit_post', 'view_post'])->pluck('id')
        );
    }
}
