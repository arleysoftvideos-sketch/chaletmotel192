<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\RecyclingStore;
use App\Models\RecyclingLog;

class RecyclingDbTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test saving a store to database and fetching it.
     */
    public function test_save_store_locally_and_fetch_via_api(): void
    {
        $storeData = [
            'nombre' => 'Test DB Store Extra',
            'telefono' => '(386) 999-8888',
            'web' => 'https://extra.com',
            'ruta' => 'Volusia',
            'empresa' => 'Independent DB Group',
            'alerta' => 'Sí'
        ];

        // Perform post to recycling/save
        $response = $this->post('/recycling/save', $storeData);

        // It should redirect
        $response->assertStatus(302);

        // Assert store exists in local DB
        $this->assertDatabaseHas('recycling_stores', [
            'nombre' => 'Test DB Store Extra',
            'telefono' => '(386) 999-8888',
            'alerta' => 'Sí'
        ]);

        // Assert it appears in get recycling stores list
        $responseStores = $this->getJson('/api/recycling/stores');
        $responseStores->assertStatus(200);
        $this->assertContains('Test DB Store Extra', $responseStores->json('stores'));
    }

    /**
     * Test saving a log and calculating stats.
     */
    public function test_log_recycling_and_calculate_stats(): void
    {
        // Add direct logs in local DB
        RecyclingLog::create([
            'date' => '2026-06-01',
            'store' => 'Test DB Store A',
            'big' => 10,
            'small' => 5,
            'total' => 15
        ]);

        RecyclingLog::create([
            'date' => '2026-06-02',
            'store' => 'Test DB Store B',
            'big' => 20,
            'small' => 10,
            'total' => 30
        ]);

        // Call stats API without filters
        $response = $this->getJson('/api/recycling/stats');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'success' => true
        ]);

        $summary = $response->json('summary');
        // The summary should include at least our 2 logs
        $this->assertGreaterThanOrEqual(45, $summary['total']);
        $this->assertGreaterThanOrEqual(30, $summary['big']);
        $this->assertGreaterThanOrEqual(15, $summary['small']);

        // Call stats API with specific date filter range
        $responseFiltered = $this->getJson('/api/recycling/stats?start_date=2026-06-01&end_date=2026-06-02');
        $responseFiltered->assertStatus(200);
        $summaryFiltered = $responseFiltered->json('summary');
        
        $this->assertEquals(45, $summaryFiltered['total']);
        $this->assertEquals(30, $summaryFiltered['big']);
        $this->assertEquals(15, $summaryFiltered['small']);
        $this->assertEquals(2, $summaryFiltered['count']);

        // Verify top locations sorting
        $locations = $responseFiltered->json('locations');
        $this->assertEquals('Test DB Store B', $locations[0]['store']);
        $this->assertEquals(30, $locations[0]['total_sum']);
        $this->assertEquals('Test DB Store A', $locations[1]['store']);
        $this->assertEquals(15, $locations[1]['total_sum']);
    }
}
