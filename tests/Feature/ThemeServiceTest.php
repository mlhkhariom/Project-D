<?php

namespace Tests\Feature;

use App\Services\ThemeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Tests\TestCase;

class ThemeServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_theme_service_is_optimized()
    {
        // Ensure settings table exists and has a value
        if (!Schema::hasTable('settings')) {
            Schema::create('settings', function ($table) {
                $table->string('key')->primary();
                $table->string('value');
            });
             DB::table('settings')->insert(['key' => 'active_theme', 'value' => 'theme_1']);
        }

        // If table exists (via migration), the default value is already inserted by the migration.
        // We can ensure it's set just in case, using updateOrInsert to be safe.
        DB::table('settings')->updateOrInsert(['key' => 'active_theme'], ['value' => 'theme_1']);

        $service = app(ThemeService::class);

        DB::enableQueryLog();

        // Call it once
        $service->getActiveThemeId();

        // Call it again
        $service->getActiveThemeId();

        // Call it a third time
        $service->getActiveThemeId();

        $log = DB::getQueryLog();

        // With memoization, we expect exactly 2 queries:
        // 1. Schema::hasTable check (select exists ...)
        // 2. The actual select query
        // Subsequent calls should trigger 0 queries.

        $this->assertCount(2, $log, "Expected 2 queries (schema check + select), but got " . count($log));
    }
}
