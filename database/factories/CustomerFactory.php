<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'shopname'=> $this->faker->name,
            'email'=> $this->faker->email,
            'phone'=> $this->faker->e164PhoneNumber,
            'address'=> $this->faker->jobTitle
        ];
    }
}
