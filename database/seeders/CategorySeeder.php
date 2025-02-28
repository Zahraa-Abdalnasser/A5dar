<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
        'cat_name' => 'Fruits'
        ]); 
        Category::create([
        'cat_name' => 'Vegetables'
        ]); 
        Category::create([
        'cat_name' => 'Herbs'
        ]); 
        Category::create([
        'cat_name' => 'Seeds'
        ]); 
    }
}
