<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ThemePerformanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_theme_query_performance()
    {
        // Theme is already seeded by migration

        // Enable query logging
        DB::enableQueryLog();

        // Visit homepage
        $response = $this->get('/');

        $response->assertStatus(200);

        // Get query count
        $queries = DB::getQueryLog();
        $count = count($queries);

        // Assert query count is optimized (should be <= 2: 1 schema check + 1 fetch)
        // If not memoized, this will be much higher due to View::composer('*')
        $this->assertLessThanOrEqual(2, $count, "Too many database queries on homepage. Expected <= 2, got {$count}. Likely missing memoization in ThemeService.");
    }
}
