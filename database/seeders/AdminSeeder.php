<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{

    public function run(): void
    {
        Admin::create([
            'name' => 'Al-Mutasim Bellah',
            'email' => 'mutasim@admin.com',
            'password' => bcrypt('123456789')
        ]);
    }
}
