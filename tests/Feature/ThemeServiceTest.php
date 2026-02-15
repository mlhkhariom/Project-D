<?php

namespace Tests\Feature;

use App\Services\ThemeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ThemeServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_active_theme_queries_database_once()
    {
        // Setup
        $service = app(ThemeService::class);

        // Seed initial value
        DB::table('settings')->where('key', 'active_theme')->update(['value' => 'theme_2']);

        DB::enableQueryLog();

        // Call multiple times
        $first = $service->getActiveThemeId();
        $second = $service->getActiveThemeId();
        $third = $service->getActiveThemeId();

        $queries = DB::getQueryLog();

        // Assertions
        $this->assertEquals('theme_2', $first);
        $this->assertEquals('theme_2', $second);
        $this->assertEquals('theme_2', $third);

        // Expect at most 2 queries (1 Schema check + 1 Select)
        // Without optimization it was 6.
        $this->assertLessThanOrEqual(2, count($queries), 'Should query DB only once (plus schema check). Got: '.count($queries));
    }

    public function test_set_active_theme_updates_cache()
    {
        $service = app(ThemeService::class);

        // Initial state
        DB::table('settings')->where('key', 'active_theme')->update(['value' => 'theme_1']);

        $this->assertEquals('theme_1', $service->getActiveThemeId());

        // Set new theme
        $service->setActiveTheme('theme_2');

        // Check if cache is updated without DB query (optional, but mainly checking correctness)
        $this->assertEquals('theme_2', $service->getActiveThemeId());

        // Verify DB is updated
        $this->assertDatabaseHas('settings', ['key' => 'active_theme', 'value' => 'theme_2']);

        // Verify subsequent calls return new value
        $this->assertEquals('theme_2', $service->getActiveThemeId());
    }
}
