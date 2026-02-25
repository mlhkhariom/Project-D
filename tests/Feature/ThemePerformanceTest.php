<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Services\ThemeService;

class ThemePerformanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_theme_settings_queries_are_optimized()
    {
        // Setup initial state
        // We expect the 'settings' table to be created by migrations

        // Enable query logging
        DB::enableQueryLog();

        // Hit the home page
        $response = $this->get('/');

        $response->assertStatus(200);

        // Get the queries
        $queries = DB::getQueryLog();

        // Let's strictly assert <= 2 queries related to settings.
        $settingsQueries = array_filter($queries, function ($query) {
            return str_contains($query['query'], 'settings');
        });

        $this->assertLessThanOrEqual(2, count($settingsQueries), "Too many queries to the settings table! Found: " . count($settingsQueries));
    }

    public function test_theme_cache_is_invalidated_on_update()
    {
        $themeService = app(ThemeService::class);

        // Ensure we start with a known state
        $themeService->setActiveTheme('theme_1');

        // Check active theme
        $this->assertEquals('theme_1', $themeService->getActiveThemeId());

        // Update theme
        $themeService->setActiveTheme('theme_2');

        // Check if cache is updated
        $this->assertEquals('theme_2', $themeService->getActiveThemeId());

        // Verify via DB as well
        $dbValue = DB::table('settings')->where('key', 'active_theme')->value('value');
        $this->assertEquals('theme_2', $dbValue);
    }
}
