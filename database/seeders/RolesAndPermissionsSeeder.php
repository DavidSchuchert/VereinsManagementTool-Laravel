<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $permissions = [
            'manage-members', 'view-members',
            'manage-inventory', 'view-inventory',
            'manage-finances', 'view-finances',
            'manage-events', 'view-events',
            'manage-documents', 'view-documents',
            'manage-protocols', 'view-protocols',
            'access-settings', 'manage-users'
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        // Create Roles and Assign Permissions
        
        // 1. Admin: Everything
        $adminRole = Role::findOrCreate('admin');
        $adminRole->givePermissionTo(Permission::all());

        // 2. MembersManager
        $membersManager = Role::findOrCreate('MembersManager');
        $membersManager->givePermissionTo(['manage-members', 'view-members', 'view-protocols']);

        // 3. InventoryManager
        $inventoryManager = Role::findOrCreate('InventoryManager');
        $inventoryManager->givePermissionTo(['manage-inventory', 'view-inventory']);

        // 4. FinancialManager
        $financialManager = Role::findOrCreate('FinancialManager');
        $financialManager->givePermissionTo(['manage-finances', 'view-finances']);

        // 5. Member (Standard User)
        $memberRole = Role::findOrCreate('member');
        $memberRole->givePermissionTo(['view-members', 'view-inventory', 'view-events', 'view-documents', 'view-protocols']);

        // 6. Guest
        $guestRole = Role::findOrCreate('guest');
        $guestRole->givePermissionTo(['view-events']);
    }
}
