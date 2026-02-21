<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ThemePerformanceTest extends TestCase
{
    public function test_homepage_loads_with_optimized_queries(): void
    {
        // Boot the app to ensure service providers are registered
        $this->get('/');

        DB::enableQueryLog();

        $response = $this->get('/');

        $response->assertStatus(200);

        $queries = DB::getQueryLog();
        $queryCount = count($queries);

        // We expect exactly 2 queries:
        // 1. Check if 'settings' table exists (Schema::hasTable)
        // 2. Fetch 'active_theme' from settings table
        // If caching is missing, this will be much higher due to View::composer('*')

        $this->assertLessThanOrEqual(2, $queryCount, "Too many queries executed: {$queryCount}. Expected <= 2.");
    }
}
