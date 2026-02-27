<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Services\ThemeService;
use Tests\TestCase;

class ThemePerformanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_theme_query_performance()
    {
        // Theme is already seeded by migration

        // Ensure cache is empty to test cold start
        Cache::forget('active_theme_id');

        // Enable query logging
        DB::enableQueryLog();

        // Visit homepage
        $response = $this->get('/');

        $response->assertStatus(200);

        // Get query count
        $queries = DB::getQueryLog();
        $count = count($queries);

        // Assert query count is optimized (should be <= 2: 1 schema check + 1 fetch)
        $this->assertLessThanOrEqual(2, $count, "Too many database queries on homepage. Expected <= 2, got {$count}.");
    }

    public function test_theme_caching_behavior()
    {
        // 1. Initial State: Cache is empty
        Cache::forget('active_theme_id');

        // Create a new service instance (simulating a fresh request)
        $service = new ThemeService();

        // 2. First Call: Should hit DB (and Schema check)
        DB::enableQueryLog();
        $id1 = $service->getActiveThemeId();
        $queries1 = DB::getQueryLog();

        // Assert we hit the DB (at least 1 query for Schema or Data)
        $this->assertGreaterThan(0, count($queries1), "First call should hit the database.");
        $this->assertEquals('theme_1', $id1); // Default if no settings

        // 3. Second Call (Different Instance): Should be cached (0 queries)
        // Simulate a new request where the service is re-instantiated
        // The persistent cache should prevent DB hits.

        DB::flushQueryLog();
        $service2 = new ThemeService(); // New instance, so local property is null

        $id2 = $service2->getActiveThemeId();
        $queries2 = DB::getQueryLog();

        $this->assertCount(0, $queries2, "Second call (from cache) should NOT hit the database.");
        $this->assertEquals($id1, $id2);
    }

    public function test_theme_update_invalidates_cache()
    {
        $service = new ThemeService();

        // 1. Set initial theme
        $service->setActiveTheme('theme_1');

        // Verify cache is cleared (our implementation does forget)
        $this->assertFalse(Cache::has('active_theme_id'));

        // 2. Accessing it again should re-populate cache with correct value
        // Use a new service instance to bypass local property cache
        $service2 = new ThemeService();
        $id = $service2->getActiveThemeId();

        $this->assertEquals('theme_1', $id);
        $this->assertTrue(Cache::has('active_theme_id'));
        $this->assertEquals('theme_1', Cache::get('active_theme_id'));

        // 3. Change theme to 'theme_2'
        $service2->setActiveTheme('theme_2');

        // Verify cache is cleared again
        $this->assertFalse(Cache::has('active_theme_id'));

        // 4. Verify next fetch gets new value
        $service3 = new ThemeService();
        $newId = $service3->getActiveThemeId();

        $this->assertEquals('theme_2', $newId);
        $this->assertEquals('theme_2', Cache::get('active_theme_id'));
    }
}
