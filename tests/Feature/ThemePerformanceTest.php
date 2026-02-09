<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ThemePerformanceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the homepage doesn't have N+1 queries for theme settings.
     */
    public function test_homepage_performance(): void
    {
        // First request to warm up anything (like caching if it existed)
        $this->get('/');

        // Enable query logging
        DB::enableQueryLog();

        // Make the request
        $response = $this->get('/');
        $response->assertStatus(200);

        // Get the queries
        $queries = DB::getQueryLog();
        $queryCount = count($queries);

        // Analyze queries for 'settings' table
        $settingsQueries = array_filter($queries, function ($query) {
            // Check if query is about settings table
            return str_contains($query['query'], 'settings');
        });

        $settingsQueryCount = count($settingsQueries);

        // Assert that we don't have excessive queries.
        // If the view composer runs multiple times without memoization, this will be > 1.
        // We expect exactly 0 if cached properly (and cache was warmed), or 1 if just memoized per request.
        // Given we are targeting < 2 queries for settings.
        $this->assertLessThan(2, $settingsQueryCount, "Too many queries for active theme setting. Found: {$settingsQueryCount}");
    }
}
