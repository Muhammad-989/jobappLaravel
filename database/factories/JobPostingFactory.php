<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Company;
use App\Models\JobPosting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<JobPosting>
 */
class JobPostingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'category_id' => Category::factory(),
            'title' => fake()->jobTitle(),
            'description' => fake()->paragraphs(3, true),
            'location' => fake()->city(),
            'employment_type' => fake()->randomElement(['Full-time', 'Part-time', 'Contract', 'Remote']),
            'salary_min' => fake()->numberBetween(40000, 70000),
            'salary_max' => fake()->numberBetween(70001, 140000),
            'status' => 'published',
            'published_at' => now(),
        ];
    }
}
