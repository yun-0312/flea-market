<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'comment' => $this->faker->sentence(),
            'user_id' => User::factory()->hasProfile(),
            'item_id' => Item::factory(),
        ];
    }
}
