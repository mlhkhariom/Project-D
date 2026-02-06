<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Services\ThemeService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThemePerformanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_theme_settings_queries_are_optimized()
    {
        Cache::flush();
        DB::enableQueryLog();

        // 1st Request (Cold Cache) - should trigger queries
        $this->get('/');

        // 2nd Request (Warm Cache) - should NOT trigger queries
        DB::flushQueryLog();
        $this->get('/');

        $queries = DB::getQueryLog();

        // Filter queries to be sure we are looking for settings/schema queries
        $settingsQueries = collect($queries)->filter(function ($query) {
            return str_contains($query['query'], 'settings') || str_contains($query['query'], 'sqlite_master');
        });

        // Assert queries count == 0.
        $this->assertCount(0, $settingsQueries, 'Expected 0 DB queries on subsequent requests due to caching.');
    }
}
