<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ThemePerformanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_theme_query_performance()
    {
        // Theme is already seeded by migration

        // Enable query logging
        DB::enableQueryLog();

        // Visit homepage
        $response = $this->get('/');

        $response->assertStatus(200);

        // Get query count
        $queries = DB::getQueryLog();
        $count = count($queries);

        // Assert query count is optimized (should be <= 2: 1 schema check + 1 fetch)
        // If not memoized, this will be much higher due to View::composer('*')
        $this->assertLessThanOrEqual(2, $count, "Too many database queries on homepage. Expected <= 2, got {$count}. Likely missing memoization in ThemeService.");
    }

    public function test_homepage_theme_query_performance_with_warm_cache()
    {
        // First request to warm the cache
        $this->get('/');

        // Enable query logging after cache is warm
        DB::enableQueryLog();

        // Second request
        $response = $this->get('/');
        $response->assertStatus(200);

        // Get query log
        $queries = DB::getQueryLog();
        $count = 0;
        foreach ($queries as $query) {
            // Count queries touching settings or sqlite_master
            if (str_contains($query['query'], 'settings') || str_contains($query['query'], 'sqlite_master')) {
                $count++;
            }
        }

        // Assert zero database queries for theme fetching on a warm cache
        $this->assertEquals(0, $count, "Found {$count} theme-related queries despite warm cache. Expected 0.");
    }

    public function test_theme_cache_invalidation()
    {
        $themeService = app(\App\Services\ThemeService::class);

        // Ensure cache is populated
        $initialTheme = $themeService->getActiveThemeId();

        // Assert cache contains value
        $this->assertTrue(\Illuminate\Support\Facades\Cache::has('active_theme_id'));
        $this->assertEquals($initialTheme, \Illuminate\Support\Facades\Cache::get('active_theme_id'));

        // Update theme
        $themeService->setActiveTheme('theme_2');

        // Assert cache is invalidated
        $this->assertFalse(\Illuminate\Support\Facades\Cache::has('active_theme_id'));

        // Assert new value is retrieved correctly (and cached again)
        // We use a new instance to ensure we aren't just hitting the local class property cache
        $newThemeService = new \App\Services\ThemeService();
        $newTheme = $newThemeService->getActiveThemeId();

        $this->assertEquals('theme_2', $newTheme);
        $this->assertTrue(\Illuminate\Support\Facades\Cache::has('active_theme_id'));
        $this->assertEquals('theme_2', \Illuminate\Support\Facades\Cache::get('active_theme_id'));
    }
}
