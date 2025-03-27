<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    // Reset cached roles and permissions
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    // Create permissions
    $permissions = [
        'create posts',
        'edit posts',
        'delete posts',
        'manage users',
        'manage categories'
    ];
    
    foreach ($permissions as $permission) {
        Permission::create(['name' => $permission]);
    }

    // Create roles and assign permissions
    $admin = Role::create(['name' => 'admin']);
    $admin->givePermissionTo(Permission::all());

    $editor = Role::create(['name' => 'editor']);
    $editor->givePermissionTo(['create posts', 'edit posts']);

    Role::create(['name' => 'reader']);
}
}
