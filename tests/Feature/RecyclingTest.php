<?php

namespace Tests\Feature;

use Tests\TestCase;

class RecyclingTest extends TestCase
{
    /**
     * Test the recycling route returns status 200.
     */
    public function test_recycling_page_returns_successful_response(): void
    {
        $response = $this->get('/recycling');

        $response->assertStatus(200);
        $response->assertSee('Recycling Guide');
    }

    /**
     * Test the recycling page supports language query parameter for English.
     */
    public function test_recycling_page_supports_english_locale(): void
    {
        $response = $this->get('/recycling?lang=en');

        $response->assertStatus(200);
        $response->assertSee('Recycling Guide');
    }

    /**
     * Test the recycling page supports language query parameter for Spanish.
     */
    public function test_recycling_page_supports_spanish_locale(): void
    {
        $response = $this->get('/recycling?lang=es');

        $response->assertStatus(200);
        $response->assertSee('Guía de Reciclaje');
    }
}
