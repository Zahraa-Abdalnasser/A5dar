<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\offer;
use App\Models\User;
class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $users = User::all(); // Fetch all users

        offer::create([
            'offer_name' => 'tomatos', 
            'amount' => 235, 
            'unit_price'=> 23, 
            'status' => 1 , 
            'unit_id' =>1 , 
            'cat_id' => 2 ,
            'image_path' => 'D:\my-api\storage\app\public\profiles\5bmCR5hhGB9XJ0RZ7oypUyv5MThSQHb4CkidxRfV.png',
            'user_id' => $users->random()->id, // Assign a random user
        ]);

    }
}
