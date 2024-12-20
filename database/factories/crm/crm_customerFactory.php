<?php

namespace Database\Factories\crm;

use App\Models\crm\crm_customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class crm_customerFactory extends Factory
{
    protected $model = crm_customer::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'sales' => collect(['David', 'Heri', 'Dika'])->random(),
            'area' => $this->faker->state(),
            'address' => implode(', ', [
                // $this->faker->streetAddress(),
                $this->faker->city()
                // $this->faker->state()
            ]),
            'phonenumber' => $this->faker->phoneNumber(),
            'mobilephone' => $this->faker->phoneNumber(),
            'company' => $this->faker->company(),
            'position' => implode(' ', $this->faker->words(3)),
            'status' => $this->faker->boolean(),
        ];
    }
}
