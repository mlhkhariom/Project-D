<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ThemeServicePerformanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_query_count()
    {
        DB::enableQueryLog();

        $response = $this->get('/');

        $response->assertStatus(200);

        $queries = DB::getQueryLog();

        // Expect at most 2 queries:
        // 1. Check if settings table exists
        // 2. Fetch active theme
        $this->assertLessThanOrEqual(2, count($queries), 'Query count should be minimal (cached).');
    }
}
