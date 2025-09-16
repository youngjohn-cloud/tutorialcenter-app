<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Staff>
 */
class StaffFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'staff_id' => strtoupper(Str::random(8)), // e.g. "LGA70QPB"
            'firstname' => $this->faker->firstName(),
            'lastname'  => $this->faker->lastName(),
            'email'     => $this->faker->unique()->safeEmail(),
            'phone'     => $this->faker->unique()->phoneNumber(),
            'password'  => Hash::make('password'), // default password
            'gender'    => $this->faker->randomElement(['Male', 'Female', 'Others']),
            'staff_role'=> $this->faker->randomElement(['admin','tutor','adviser','staff']),
            'profile_picture' => null, // you can later set default avatar
            'date_of_birth'   => $this->faker->date(),

            'email_verified_at' => null,
            'phone_verified_at' => null,
            'verification_code' => Str::random(6),
            'verified' => $this->faker->boolean(),

            'status' => $this->faker->randomElement(['active', 'inactive', 'disabled']),
            'home_address' => $this->faker->address(),
            'indected_by'  => null, // until you link to another staff
        ];
    }
}
