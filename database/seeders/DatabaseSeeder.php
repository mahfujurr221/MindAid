<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Creating super admin user
        $superAdmin = User::create([
            'fname' => 'Super',
            'lname' => 'Admin',
            'type' => 'supper-admin', 
            'email' => 'supper-admin@ehealthcare.com',
            'phone' => '00000000000',
            'password' => bcrypt('supperadmin1234'),
        ]);

        // Creating roles
        Role::create(['name' => 'Super Admin', 'guard_name' => 'web']);
        Role::create(['name' => 'Operator', 'guard_name' => 'web']);
        Role::create(['name' => 'Doctor', 'guard_name' => 'web']);
        Role::create(['name' => 'Patient', 'guard_name' => 'web']);

        // Creating settings
        $setting = Setting::create([
            'site_name' => 'E-Healthcare',
            'site_title' => 'E-Healthcare',
            'logo' => 'logo.png',
            'favicon' => 'favicon.png',
            'email' => 'info@e-healthcare.com',
            'phone' => '01781342259',
            'address' => 'Dhaka, Bangladesh',
            'footer_text' => '© 2021 E-Healthcare. All rights reserved.',
            'newslatter_text' => 'Subscribe to our newsletter',
            'facebook' => 'https://www.facebook.com/',
        ]);

        // Assigning roles to users
        $superAdmin->assignRole('Super Admin');
        // Call Permission Seeder
        $this->call(PermissionTableSeeder::class);
    }
}
