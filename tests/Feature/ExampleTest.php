<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test that the apuestas page loads successfully.
     */
    public function test_apuestas_page_loads_successfully(): void
    {
        $response = $this->get('/apuestas');

        $response->assertStatus(200);
        $response->assertSee('Apuestas');
    }
}
