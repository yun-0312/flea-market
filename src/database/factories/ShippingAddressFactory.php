<?php

namespace Database\Factories;

use App\Models\ShippingAddress;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShippingAddressFactory extends Factory
{
    protected $model = ShippingAddress::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'   => User::factory(),
            'post_code' => $this->faker->postcode(),
            'address'   => $this->faker->address(),
            'building'  => $this->faker->secondaryAddress(),
        ];
    }
}
