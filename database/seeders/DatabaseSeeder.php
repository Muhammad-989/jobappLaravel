<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Company;
use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = collect(['Engineering', 'Design', 'Marketing', 'Customer Support'])
            ->mapWithKeys(fn (string $name) => [$name => Category::create(['name' => $name])]);

        $company = Company::factory()->create([
            'name' => 'Northstar Labs',
            'location' => 'Remote',
        ]);

        JobPosting::factory(6)->create([
            'company_id' => $company->id,
            'category_id' => $categories->random()->id,
        ]);

        User::factory()->create([
            'name' => 'Test Jobseeker',
            'email' => 'test@example.com',
        ]);
    }
}
