<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ThemePerformanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_performance()
    {
        // Settings table is populated by migration

        // Clear cache to ensure we start fresh
        Cache::forget('active_theme');

        DB::enableQueryLog();

        // First request - should hit DB and Cache
        $this->get('/');

        $queries = DB::getQueryLog();
        $initialCount = count($queries);

        // Assert initial query count is low (max 2: schema check + settings fetch)
        $this->assertLessThanOrEqual(2, $initialCount);

        // Flush query log
        DB::flushQueryLog();

        // Second request - should hit Cache (0 DB queries)
        $this->get('/');

        $queries2 = DB::getQueryLog();
        $secondCount = count($queries2);

        // Assert subsequent query count is 0
        $this->assertEquals(0, $secondCount);
    }
}
