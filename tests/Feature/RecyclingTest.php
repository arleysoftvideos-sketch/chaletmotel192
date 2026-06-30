<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecyclingTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test the recycling route returns status 200.
     */
    public function test_recycling_page_returns_successful_response(): void
    {
        $response = $this->get('/recycling');

        $response->assertStatus(200);
        $response->assertSee('Ameritex Diversion Inc.');
    }

    /**
     * Test the recycling page supports language query parameter for English.
     */
    public function test_recycling_page_supports_english_locale(): void
    {
        $response = $this->get('/recycling?lang=en');

        $response->assertStatus(200);
        $response->assertSee('Directory of 100 Stores');
    }

    /**
     * Test the recycling page supports language query parameter for Spanish.
     */
    public function test_recycling_page_supports_spanish_locale(): void
    {
        $response = $this->get('/recycling?lang=es');

        $response->assertStatus(200);
        $response->assertSee('Directorio de 100 Tiendas');
    }

    /**
     * Test the GET stores API returns list of stores.
     */
    public function test_get_recycling_stores_returns_stores_list(): void
    {
        \App\Models\RecyclingStore::create([
            'nombre' => 'Citgo',
            'telefono' => '12345',
            'web' => 'https://citgo.com',
            'ruta' => 'Volusia',
            'empresa' => 'Gasolineras',
            'alerta' => 'No'
        ]);
        \App\Models\RecyclingStore::create([
            'nombre' => 'SHELL',
            'telefono' => '12345',
            'web' => 'https://shell.com',
            'ruta' => 'Volusia',
            'empresa' => 'Gasolineras',
            'alerta' => 'No'
        ]);

        $response = $this->getJson('/api/recycling/stores');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'stores'
        ]);
        $response->assertJsonFragment(['success' => true]);
        
        $stores = $response->json('stores');
        $this->assertContains('CITGO', $stores);
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

    /**
     * Test the saveToSheets action fails validation with empty inputs.
     */
    public function test_save_to_sheets_validation_fails_with_empty_inputs(): void
    {
        $response = $this->post('/recycling/save', []);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['nombre', 'telefono', 'web', 'ruta', 'empresa', 'alerta']);
    }

    /**
     * Test the saveToSheets action fails validation with invalid route.
     */
    public function test_save_to_sheets_validation_fails_with_invalid_route(): void
    {
        $response = $this->post('/recycling/save', [
            'nombre' => 'Test Store',
            'telefono' => '1234567890',
            'web' => 'https://test.com',
            'ruta' => 'InvalidRoute',
            'empresa' => 'Test Corp',
            'alerta' => 'No'
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['ruta']);
    }

    /**
     * Test the saveToSheets action fails validation with invalid alerta.
     */
    public function test_save_to_sheets_validation_fails_with_invalid_alerta(): void
    {
        $response = $this->post('/recycling/save', [
            'nombre' => 'Test Store',
            'telefono' => '1234567890',
            'web' => 'https://test.com',
            'ruta' => 'Volusia',
            'empresa' => 'Test Corp',
            'alerta' => 'Maybe'
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['alerta']);
    }
}
