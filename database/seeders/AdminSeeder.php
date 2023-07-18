<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{

    public function run(): void
    {
        Admin::create([
            'name' => 'Admin Ocean',
            'email' => 'admin@books.com',
            'password' => Hash::make('123456789'),
        ]);
    }
}
