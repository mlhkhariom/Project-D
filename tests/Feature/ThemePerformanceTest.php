<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ThemePerformanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_load_triggers_minimal_queries_related_to_theme_settings()
    {
        // Ensure the settings table exists (migration should handle this with RefreshDatabase)
        // The migration already seeds the default theme.

        // Enable query logging
        DB::enableQueryLog();

        // Hit the homepage
        $response = $this->get('/');

        $response->assertStatus(200);

        // Get the query log
        $queries = DB::getQueryLog();

        // Count queries related to the 'settings' table or schema checks
        $settingsQueries = collect($queries)->filter(function ($query) {
            $sql = strtolower($query['query']);
            return str_contains($sql, 'select') && (
                str_contains($sql, 'settings') ||
                str_contains($sql, 'sqlite_master')
            );
        });

        // dump("Total settings related queries: " . $settingsQueries->count());
        // foreach($settingsQueries as $q) {
        //      dump($q['query']);
        // }

        // The goal is 2 queries (1 schema check + 1 fetch)
        $this->assertLessThanOrEqual(2, $settingsQueries->count(), "Too many theme-related queries executed.");
    }
}
