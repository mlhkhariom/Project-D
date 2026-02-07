<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ThemeTest extends TestCase
{
    use RefreshDatabase;

    public function test_theme_service_does_not_cause_n_plus_one_queries()
    {
        // Enable query logging
        DB::enableQueryLog();

        // Make a request to the home page
        // Assuming the home page uses multiple views/components
        $response = $this->get('/');

        $response->assertStatus(200);

        // Get the query log
        $queries = DB::getQueryLog();

        // Count queries related to the settings table
        $settingQueries = collect($queries)->filter(function ($query) {
            return str_contains($query['query'], 'select "value" from "settings" where "key" = ?');
        });

        // Fail if we see multiple queries for the same setting
        // We expect exactly 1 query (or 0 if cached, but initially it's uncached)
        // With View::composer('*'), this will likely be > 1 without optimization
        $this->assertLessThanOrEqual(1, $settingQueries->count(), 'Too many queries for active_theme: '.$settingQueries->count());
    }
}
