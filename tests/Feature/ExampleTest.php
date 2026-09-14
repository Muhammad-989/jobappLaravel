<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Vite;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        Vite::shouldReceive('__invoke')->zeroOrMoreTimes()->andReturn('');

        $response = $this->get('/jobs');

        $response->assertStatus(200);
    }
}
