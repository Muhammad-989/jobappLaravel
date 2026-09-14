<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Company;
use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Vite;
use Tests\TestCase;

class JobPortalTest extends TestCase
{
    use RefreshDatabase;

    public function test_jobseekers_can_filter_published_jobs(): void
    {
        Vite::shouldReceive('__invoke')->zeroOrMoreTimes()->andReturn('');

        $company = Company::factory()->create();
        $category = Category::factory()->create(['name' => 'Engineering']);
        JobPosting::factory()->create([
            'company_id' => $company->id,
            'category_id' => $category->id,
            'title' => 'Laravel Developer',
        ]);
        JobPosting::factory()->create(['company_id' => $company->id, 'title' => 'Product Designer']);

        $response = $this->get('/jobs?q=Laravel');

        $response->assertOk()->assertSee('Laravel Developer')->assertDontSee('Product Designer');
    }

    public function test_a_jobseeker_can_apply_only_once(): void
    {
        Vite::shouldReceive('__invoke')->zeroOrMoreTimes()->andReturn('');

        $jobseeker = User::factory()->create();
        $job = JobPosting::factory()->create();

        $payload = ['cover_letter' => 'I would love to bring my experience to this role.'];

        $this->actingAs($jobseeker)->post(route('applications.store', $job), $payload)->assertRedirect();
        $this->actingAs($jobseeker)->post(route('applications.store', $job), $payload)
            ->assertSessionHasErrors('application');

        $this->assertDatabaseCount('applications', 1);
    }
}
