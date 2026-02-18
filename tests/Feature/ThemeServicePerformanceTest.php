<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ThemeServicePerformanceTest extends TestCase
{
    public function test_homepage_queries_count()
    {
        // We need to ensure the settings table exists or at least the schema check passes
        // The memory says "In SQLite environments, Schema::hasTable operations are logged as select exists queries"

        DB::enableQueryLog();

        $this->get('/');

        $log = DB::getQueryLog();
        $count = count($log);

        // Filter queries related to settings table
        $settingsQueries = array_filter($log, function ($query) {
            return str_contains($query['query'], 'settings') || str_contains($query['query'], 'sqlite_master');
        });

        // Expectation: 2 queries (1 schema check + 1 fetch)
        // If it's more, we have a problem.
        $this->assertLessThanOrEqual(2, count($settingsQueries), 'Too many queries to settings table: '.count($settingsQueries));
    }
}
