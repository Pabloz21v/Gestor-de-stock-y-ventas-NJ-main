<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $role_admin = Role::create(['name' => 'admin']);
        $role_editor = Role::create(['name' => 'editor']);
        $role_buyer = Role::create(['name' => 'buyer']);
        // ROLES
        $permission_create_role = Permission::create([
            'name' => 'create roles'
        ]);
        $permission_read_role = Permission::create([
            'name' => 'read roles'
        ]);
        $permission_update_role = Permission::create([
            'name' => 'update roles'
        ]);
        $permission_delete_role = Permission::create([
            'name' => 'delete roles'
        ]);
        // PRODUCTOS
        $permission_create_product = Permission::create([
            'name' => 'create products'
        ]);
        $permission_read_product = Permission::create([
            'name' => 'read products'
        ]);
        $permission_update_product = Permission::create([
            'name' => 'update products'
        ]);
        $permission_delete_product = Permission::create([
            'name' => 'delete products'
        ]);
        // CATEGORIAS
        $permission_create_category = Permission::create([
            'name' => 'create categories'
        ]);
        $permission_read_category = Permission::create([
            'name' => 'read categories'
        ]);
        $permission_update_category = Permission::create([
            'name' => 'update categories'
        ]);
        $permission_delete_category = Permission::create([
            'name' => 'delete categories'
        ]);

        $permissions_admin = [
            $permission_create_role, $permission_read_role, $permission_update_role, $permission_delete_role,
            $permission_create_product, $permission_read_product, $permission_update_product, $permission_delete_product,
            $permission_create_category, $permission_read_category, $permission_update_category, $permission_delete_category
        ];
        $permissions_editor = [
            $permission_create_product, $permission_read_product, $permission_update_product, $permission_delete_product,
            $permission_create_category, $permission_read_category, $permission_update_category, $permission_delete_category
        ];
        $permissions_buyer = [$permission_read_product, $permission_read_category];

        $role_admin->syncPermissions($permissions_admin);
        $role_editor->syncPermissions($permissions_editor);
        $role_buyer->syncPermissions($permissions_buyer);
        // $role_buyer->givePermmisionTo($permission_buyer);
    }
}
