<?php

namespace Database\Factories;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    protected $model = Profile::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => null,
            'image_url' => 'default-profile.jpg',
            'post_code' => $this->faker->postcode(),
            'address' => $this->faker->address(),
            'building' => $this->faker->secondaryAddress(),
        ];
    }
}
