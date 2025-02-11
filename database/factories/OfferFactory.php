<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\offer;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offer>
 */
class OfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    
        protected $model = offer::class; // Connect factory to Offer model

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(), // Random offer title
            'discount' => $this->faker->randomFloat(2, 5, 50), // Discount between 5% and 50%
            'expires_at' => $this->faker->dateTimeBetween('+1 week', '+1 month'), // Expiration date
            'description' => $this->faker->paragraph(), // Random description
        ];
    }
    
}
