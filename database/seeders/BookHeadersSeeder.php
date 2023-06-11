<?php

namespace Database\Seeders;

use App\Models\BookHeader;
use Illuminate\Database\Seeder;

class BookHeadersSeeder extends Seeder
{
    public function run(): void
    {
        $headers = [
            ['title' => 'Readers'],
            ['title' => 'Skills'],
            ['title' => 'Student Resource'],
            ['title' => 'Teacher Resource'],
        ];

        foreach ($headers as $header) {
            BookHeader::create($header);
        }
    }
}
