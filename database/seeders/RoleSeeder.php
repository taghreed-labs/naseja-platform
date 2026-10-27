<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::updateOrCreate(
            ['slug' => 'admin'],
            ['name' => 'مدير النظام']
        );

        Role::updateOrCreate(
            ['slug' => 'provider'],
            ['name' => 'صاحب مهارة']
        );

        Role::updateOrCreate(
            ['slug' => 'customer'],
            ['name' => 'عميل']
        );
    }
}
