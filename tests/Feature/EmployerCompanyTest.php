<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployerCompanyTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_employer_can_save_a_company_profile(): void
    {
        $employer = User::factory()->employer()->create();

        $response = $this->actingAs($employer)->post(route('employer.company.store'), [
            'name' => 'Northstar Labs',
            'location' => 'Remote',
            'website' => 'https://northstar.example',
            'description' => 'A small remote software company.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('companies', [
            'user_id' => $employer->id,
            'name' => 'Northstar Labs',
        ]);
    }

    public function test_an_invalid_company_website_is_reported_to_the_user(): void
    {
        $employer = User::factory()->employer()->create();

        $response = $this->actingAs($employer)->from(route('employer.dashboard'))->post(
            route('employer.company.store'),
            ['name' => 'Northstar Labs', 'website' => 'northstar.example'],
        );

        $response->assertRedirect(route('employer.dashboard'))
            ->assertSessionHasErrors('website');
    }
}
