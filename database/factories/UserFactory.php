<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $type = $this->faker->randomElement(['individual', 'entity']);
//        $type = 'individual';
        $is_foreign = false;
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber,
            'national_number' => (string)$this->faker->numberBetween(10000, 99999),
            'type' => $type,
            'number_of_employees' => $type == 'individual' ? null : $this->faker->numberBetween(0, 100),
            'is_foreign' => $is_foreign
        ];
    }

    public function entity()
    {

        return $this->state(function (array $attributes) {
            return [
                'type' => 'entity',
                'number_of_employees' => 50
            ];
        });
    }

    public function foreign()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_foreign' => true
            ];
        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
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
