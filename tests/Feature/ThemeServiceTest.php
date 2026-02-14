<?php

namespace Tests\Feature;

use App\Services\ThemeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ThemeServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_active_theme_id_caches_result()
    {
        // Settings table is created and seeded by migration
        DB::table('settings')->where('key', 'active_theme')->update(['value' => 'theme_2']);

        $service = app(ThemeService::class);

        DB::enableQueryLog();

        // First call
        $theme1 = $service->getActiveThemeId();

        // Second call
        $theme2 = $service->getActiveThemeId();

        // Third call
        $theme3 = $service->getActiveThemeId();

        $log = DB::getQueryLog();

        // Optimized: 1 Schema check + 1 Select query. Subsequent calls use cache.
        $this->assertCount(2, $log);

        $this->assertEquals('theme_2', $theme1);
        $this->assertEquals('theme_2', $theme2);
        $this->assertEquals('theme_2', $theme3);
    }
}
