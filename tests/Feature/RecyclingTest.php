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

    /**
     * Test the GET stores API returns list of stores.
     */
    public function test_get_recycling_stores_returns_stores_list(): void
    {
        $response = $this->getJson('/api/recycling/stores');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'stores'
        ]);
        $response->assertJsonFragment(['success' => true]);
        
        $stores = $response->json('stores');
        $this->assertContains('Citgo', $stores);
        $this->assertContains('SHELL', $stores);
    }

    /**
     * Test the POST log API fails validation with empty inputs.
     */
    public function test_store_recycling_log_fails_validation_with_empty_inputs(): void
    {
        $response = $this->postJson('/api/recycling/log', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['date', 'store', 'big', 'small', 'total']);
    }
}
