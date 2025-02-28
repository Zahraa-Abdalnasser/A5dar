<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
        'name' => 'zhra', 
        'email' => 'zhra@gmail.com', 
        'password' => '12345678', 
        'description' => 'Falaha'
            ]) ;
        User::create([
        'name' => 'aya', 
        'email' => 'ayaa@gmail.com', 
        'password' => '12345678', 
        'description' => 'Falaha'
            ]) ;
        User::create([
        'name' => 'alia', 
        'email' => 'alia@gmail.com', 
        'password' => '12345678', 
        'description' => 'Falaha'
            ]) ;
        User::create([
        'name' => 'zienab', 
        'email' => 'zienab@gmail.com', 
        'password' => '12345678', 
        'description' => 'Falaha'
            ]) ;
        User::create([
        'name' => 'fatma', 
        'email' => 'fatma@gmail.com', 
        'password' => '12345678', 
        'description' => 'Falaha'
            ]) ;
    }
}
