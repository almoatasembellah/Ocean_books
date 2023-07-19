<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{

    public function run(): void
    {
        $adminRole = Role::findOrCreate('admin');

        $admin = User::create(
            ['name' => 'Administrator', 'email' => 'admin@books.com', 'password' => Hash::make('12345678'), 'phone' => '01092782741', 'position' => 'administrator']
        );
        $admin->assignRole($adminRole);
    }
}
