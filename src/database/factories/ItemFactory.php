<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected $model = Item::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'    => User::factory(),
            'name'       => $this->faker->word(),
            'brand'      => $this->faker->company(),
            'description' => $this->faker->sentence(),
            'price'      => $this->faker->numberBetween(500, 30000),
            'image_url'  => $this->faker->imageUrl(),
            'condition'  => $this->faker->randomElement([1, 2, 3, 4]),
        ];
    }
}