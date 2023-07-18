<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Student Categoy', 'level' =>'from level 1 to level 2', 'cover'=> 'categories-covers/O5lLidvzkir90nwaq0rpklyWAdWxw9C8ss0VdLnZ.png','book_header_id' =>3],
            ['name' => 'Teacher Categoy', 'level' =>'from level 2 to level 5', 'cover'=> 'categories-covers/CDb6Eboa7LDtLwvJWRZt5u2AW1m4VjbdhJoPZBMN.png','book_header_id' =>4],
        ];
        foreach ($categories as $category){
            Category::create($category);
        }
    }
}
