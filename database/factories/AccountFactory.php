<?php

namespace Database\Factories;

use App\Enum\AccountTypesEnum;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'account_id' => fake()->name(),
            'account_type' => fake()->randomElement(['savings', 'current']),
            'currency' => fake()->randomElement(['dollar', 'euro', 'pounds']),
            'amount' => fake()->realText(fake()->numberBetween(100, 1000)),
        ];
    }
}
