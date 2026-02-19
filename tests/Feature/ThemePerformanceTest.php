<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ThemePerformanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_queries_are_optimal()
    {
        // Setup: Ensure settings table has the theme
        if (Schema::hasTable('settings')) {
            DB::table('settings')->insertOrIgnore([
                'key' => 'active_theme',
                'value' => 'theme_1',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Enable query logging
        DB::enableQueryLog();

        // Visit homepage
        $response = $this->get('/');

        // Get query log
        $queries = DB::getQueryLog();
        $queryCount = count($queries);

        // Analyze queries
        $schemaChecks = 0;
        $settingsQueries = 0;

        foreach ($queries as $query) {
            // SQLite 'select exists' is used for Schema::hasTable
            if (str_contains($query['query'], 'select * from "settings" where "key" = ?')) {
                $settingsQueries++;
            }
             if (str_contains($query['query'], 'select count(*) as aggregate from "settings"')) {
                // Adjust this depending on how Schema::hasTable works in the specific DB driver
                 // For SQLite it is often a pragma or select from sqlite_master, but Laravel might wrap it.
                 // Let's just count total queries first.
            }
             if (str_contains($query['query'], 'sqlite_master')) {
                 $schemaChecks++;
             }
        }

        // Assertion: Should be ideally 2 (1 schema check + 1 fetch)
        // If it's more, we have a problem.
        // We set a threshold. If it's > 5, it's definitely unoptimized.
        $this->assertLessThan(5, $queryCount, "Too many queries on homepage load: {$queryCount}");
    }
}
