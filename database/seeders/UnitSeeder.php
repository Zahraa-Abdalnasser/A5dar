<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Unit; 
class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Unit::create([
        'unit_name' => 'Kilogram'
        ]); 
        
        Unit::create([
        'unit_name' => 'Ardeb'
        ]); 
        Unit::create([
        'unit_name' => 'Tons'
        ]); 
        Unit::create([
        'unit_name' => 'Box'
        ]); 
        Unit::create([
        'unit_name' => 'Bottle'
        ]); 
        
    }
}
