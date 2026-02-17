<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ThemePerformanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_queries_count()
    {
        DB::enableQueryLog();

        $this->get('/');

        $log = DB::getQueryLog();

        // Filter queries related to settings table and schema checks (sqlite_master)
        $settingsQueries = array_filter($log, function ($query) {
            return str_contains($query['query'], 'settings') || str_contains($query['query'], 'sqlite_master');
        });

        // Expectation: 2 queries max (1 schema check + 1 fetch) for the first load.
        // Subsequent calls should be cached in memory.
        $this->assertLessThanOrEqual(2, count($settingsQueries), 'Too many queries to settings table: '.count($settingsQueries));
    }
}
