<?php

namespace Database\Factories\crm;

use App\Models\crm\crm_visit_report;
use Illuminate\Database\Eloquent\Factories\Factory;

class crm_visit_reportFactory extends Factory
{
    protected $model = crm_visit_report::class;

    public function definition(): array
    {
        return [
            'sales' => collect(['David', 'Herianto Gomanti', 'Frahma Dika'])->random(),
            'customer_name' => $this->faker->name(), // Generates a full name
            'location' => $this->faker->city(), // Generates a city name
            'contact_person' => $this->faker->name(), // Generates a full name
            'contact_number' => $this->faker->phoneNumber(), // Generates a phone number
            'visit_date' => $this->faker->date(), // Generates a random date
            'visit_time' => $this->faker->time(), // Generates a random time
            'purpose' => $this->faker->sentence(), // Generates a short sentence
            'notes' => $this->faker->paragraph(), // Generates a paragraph
            'customer_feedback' => $this->faker->text(100), // Generates text up to 100 characters
            'next_steps' => $this->faker->sentence(), // Generates a short sentence
            'follow_up_date' => $this->faker->date(), // Generates a random date
            'status' => $this->faker->randomElement(['Planned', 'In Progress', 'Completed', 'Approved']), // Selects a random status
            'image' => $this->faker->imageUrl(640, 480, 'business', true, 'Faker'), // Generates a random image URL
        ];
    }
}
