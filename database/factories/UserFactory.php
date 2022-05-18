<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'username' => $this->faker->name(),
            'address' => $this->faker->address(),
            'image' => $this->faker->imageUrl('100','100'),
            'age' => $this->faker->numberBetween(10,60),
            'presentation' => $this->faker->sentence(),
            'preference' => $this->faker->randomElement(['both', 'host', 'visitor']),
            'user_role_id'=> 3,
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'=> Hash::make('user123456'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
