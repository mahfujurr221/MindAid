<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // Create permissions
        $permissions = [
            //role
            'list-role',
            'create-role',
            'edit-role',
            'delete-role',

            //permission
            'list-permission',
            'create-permission',
            'edit-permission',
            'delete-permission',

            //user
            'list-user',
            'create-user',
            'edit-user',
            'delete-user',


            //designation
            'list-designation',
            'create-designation',
            'edit-designation',
            'delete-designation',

            //department
            'list-department',
            'create-department',
            'edit-department',
            'delete-department',

            //doctor
            'list-doctor',
            'create-doctor',
            'edit-doctor',
            'delete-doctor',

            //patient
            'list-patient',
            'create-patient',
            'edit-patient',
            'delete-patient',

            //appointment
            'list-appointment',
            'create-appointment',
            'edit-appointment',
            'delete-appointment',

            //payment
            'list-payment',
            'create-payment',
            'edit-payment',
            'delete-payment',

            //about-us
            'list-about-us',
            'create-about-us',
            'edit-about-us',
            'delete-about-us',


            //profile
            'list-profile',
            'edit-profile',
            'delete-profile',


            //setting
            'update-setting',

            //dashboard
            'dashboard',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $role = Role::findByName('Super Admin');
        $role->givePermissionTo(Permission::all());
    }
}
