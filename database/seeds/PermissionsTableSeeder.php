<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminPermissions = [
            'access-dashboard',
            'view-users', 'create-users', 'edit-users', 'edit-users-roles', 'delete-users',
            'view-doctors', 'create-doctors', 'edit-doctors', 'delete-doctors',
            'view-fields', 'create-fields', 'edit-fields', 'delete-fields',
            'view-countries', 'create-countries', 'edit-countries', 'delete-countries',
            'view-governorates', 'create-governorates', 'edit-governorates', 'delete-governorates',
            'view-cities', 'create-cities', 'edit-cities', 'delete-cities',
            'view-universities', 'create-universities', 'edit-universities', 'delete-universities',
            'view-faculties', 'create-faculties', 'edit-faculties', 'delete-faculties',
            'view-majors', 'create-majors', 'edit-majors', 'delete-majors',
            'view-university-subjects', 'create-university-subjects',
            'edit-university-subjects', 'delete-university-subjects',
            'view-school-subjects', 'create-school-subjects', 'edit-school-subjects', 'delete-school-subjects',
            'view-charging-codes', 'create-charging-codes', 'edit-charging-codes', 'delete-charging-codes',
            'view-items', 'create-items', 'edit-items', 'delete-items',
            'view-rooms', 'create-rooms', 'edit-rooms', 'delete-rooms',
            'view-conversations', 'create-conversations', 'edit-conversations', 'delete-conversations',
            'view-banned-words', 'create-banned-words', 'edit-banned-words', 'delete-banned-words',
        ];
        $this->assignPermissionsToRole($adminPermissions, 'ADMIN');

        $sysSupportPermissions = [
            'access-dashboard',
            'view-users',
            'view-doctors',
            'view-fields',
            'view-countries',
            'view-governorates',
            'view-cities',
            'view-universities',
            'view-faculties',
            'view-majors',
            'view-university-subjects',
            'view-school-subjects',
            'view-charging-codes',
            'view-items',
            'view-rooms',
            'view-conversations',
            'view-banned-words',
        ];
        $this->assignPermissionsToRole($sysSupportPermissions, 'SYS_SUPPORT');

        $doctorPermissions = [
            'access-doctor-panel',
            'view-announcements', 'create-announcements', 'edit-announcements', 'delete-announcements',
            'view-doctors',
            'view-fields',
            'view-cities',
            'view-faculties',
            'view-majors',
            'view-university-subjects',
            'view-items', 'create-items', 'edit-items', 'delete-items',
        ];
        $this->assignPermissionsToRole($doctorPermissions, 'UNIVERSITY_DOCTOR');
    }

    private function assignPermissionsToRole($permissions, $roleName)
    {
        $role = Role::findByName($roleName);
        foreach ($permissions as $permission) {
            $permissionObject = Permission::findOrCreate($permission);
            $role->givePermissionTo($permissionObject);
        }
    }
}
