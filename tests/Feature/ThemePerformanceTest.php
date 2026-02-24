<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThemePerformanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_theme_queries_are_optimized()
    {
        DB::enableQueryLog();

        $this->get('/');

        $log = DB::getQueryLog();

        // Filter queries related to theme settings
        $themeQueries = collect($log)->filter(function ($query) {
            $sql = $query['query'];
            // Check for Schema::hasTable('settings') query in SQLite
            $isSchemaCheck = str_contains($sql, 'sqlite_master') && str_contains($sql, 'settings');
            // Check for accessing the settings table
            $isSettingsQuery = str_contains($sql, 'from "settings"');

            return $isSchemaCheck || $isSettingsQuery;
        });

        // We expect at most 2 queries:
        // 1. Check if settings table exists
        // 2. Fetch active_theme from settings table
        //
        // If caching is missing and View::composer runs multiple times,
        // this count will be much higher.
        $this->assertLessThanOrEqual(2, $themeQueries->count(), "Too many theme-related queries detected: " . $themeQueries->count());
    }
}
