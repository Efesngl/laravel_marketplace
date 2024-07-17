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
            ["category"=>"Bilgisayar"],
            ["category"=>"Mobile Phone"],
            ["category"=>"Game Consoles"],
            ["category"=>"Tablets"],
        ];
        Category::insert($categories);
    }
}
