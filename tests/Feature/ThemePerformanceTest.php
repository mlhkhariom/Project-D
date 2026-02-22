<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Services\ThemeService;
use Illuminate\Support\Facades\Schema;

class ThemePerformanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_theme_settings_queries_are_optimized()
    {
        // Setup initial state if needed
        if (!Schema::hasTable('settings')) {
             $this->markTestSkipped('Settings table not found.');
        }

        // Enable query logging
        DB::enableQueryLog();

        // Hit the home page which likely renders multiple views/partials
        $response = $this->get('/');

        $response->assertStatus(200);

        // Get the executed queries
        $queries = DB::getQueryLog();
        $queryCount = count($queries);

        // Analyze queries related to theme settings
        // We look for queries touching the 'settings' table specifically for 'active_theme'
        $themeQueries = array_filter($queries, function ($query) {
             // Check if query is selecting from settings
             $isSettingsQuery = str_contains($query['query'], 'select "value" from "settings"');
             // Check if the binding is for active_theme
             $hasBinding = isset($query['bindings'][0]) && $query['bindings'][0] === 'active_theme';

             return $isSettingsQuery && $hasBinding;
        });

        // SQLite specific: check for schema existence queries
        $schemaQueries = array_filter($queries, function ($query) {
             return str_contains($query['query'], 'sqlite_master') && str_contains($query['query'], 'settings');
        });


        // We expect exactly 1 query to get the theme (or 0 if cached)
        // Currently it's likely many more due to View::composer('*')

        // Start with a failing assertion if the count is high
        // If it's optimized, it should be 1 or 2 (one for schema check, one for value) per request max.
        // If we have 10 views, and it's unoptimized, it might be 20+.

        $this->assertLessThanOrEqual(2, count($themeQueries) + count($schemaQueries), "Too many theme-related queries executed.");
    }
}
