<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $categories = [
            ["category"=>"Computer"],
            ["category"=>"Mobile Phone"],
            ["category"=>"Game Console"],
        ];
        Category::insert($categories);
    }
}
