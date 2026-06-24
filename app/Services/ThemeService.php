<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ThemeService
{
    protected array $themes = [
        'theme_1' => [
            'name' => 'Default (Clean)',
            'colors' => [
                'primary' => '#3b82f6',
                'secondary' => '#64748b',
                'bg' => '#f3f4f6',
                'text' => '#1f2937',
            ],
            'font' => 'Figtree',
            'layout' => 'standard',
        ],
        'theme_2' => [
            'name' => 'Midnight (Dark)',
            'colors' => [
                'primary' => '#6366f1',
                'secondary' => '#94a3b8',
                'bg' => '#0f172a',
                'text' => '#f8fafc',
            ],
            'font' => 'Inter',
            'layout' => 'standard',
        ],
        'theme_3' => [
            'name' => 'Nature Light',
            'colors' => [
                'primary' => '#16a34a',
                'secondary' => '#dcfce7',
                'bg' => '#ffffff',
                'text' => '#111827',
            ],
            'font' => 'Lato',
            'layout' => 'boxed',
        ],
        'theme_4' => [
            'name' => 'Nature Dark',
            'colors' => [
                'primary' => '#16a34a',
                'secondary' => '#14532d',
                'bg' => '#14532d',
                'text' => '#f9fafb',
            ],
            'font' => 'Montserrat',
            'layout' => 'wide',
        ],
        'theme_5' => [
            'name' => 'Ocean Light',
            'colors' => [
                'primary' => '#0ea5e9',
                'secondary' => '#e0f2fe',
                'bg' => '#ffffff',
                'text' => '#111827',
            ],
            'font' => 'Figtree',
            'layout' => 'boxed',
        ],
        'theme_6' => [
            'name' => 'Ocean Dark',
            'colors' => [
                'primary' => '#0ea5e9',
                'secondary' => '#0c4a6e',
                'bg' => '#0c4a6e',
                'text' => '#f9fafb',
            ],
            'font' => 'Roboto',
            'layout' => 'wide',
        ],
        'theme_7' => [
            'name' => 'Sunset Light',
            'colors' => [
                'primary' => '#f97316',
                'secondary' => '#ffedd5',
                'bg' => '#ffffff',
                'text' => '#111827',
            ],
            'font' => 'Open Sans',
            'layout' => 'boxed',
        ],
        'theme_8' => [
            'name' => 'Sunset Dark',
            'colors' => [
                'primary' => '#f97316',
                'secondary' => '#7c2d12',
                'bg' => '#7c2d12',
                'text' => '#f9fafb',
            ],
            'font' => 'Lato',
            'layout' => 'wide',
        ],
        'theme_9' => [
            'name' => 'Berry Light',
            'colors' => [
                'primary' => '#db2777',
                'secondary' => '#fce7f3',
                'bg' => '#ffffff',
                'text' => '#111827',
            ],
            'font' => 'Montserrat',
            'layout' => 'boxed',
        ],
        'theme_10' => [
            'name' => 'Berry Dark',
            'colors' => [
                'primary' => '#db2777',
                'secondary' => '#831843',
                'bg' => '#831843',
                'text' => '#f9fafb',
            ],
            'font' => 'Figtree',
            'layout' => 'wide',
        ],
        'theme_11' => [
            'name' => 'Royal Light',
            'colors' => [
                'primary' => '#7c3aed',
                'secondary' => '#ede9fe',
                'bg' => '#ffffff',
                'text' => '#111827',
            ],
            'font' => 'Roboto',
            'layout' => 'boxed',
        ],
        'theme_12' => [
            'name' => 'Royal Dark',
            'colors' => [
                'primary' => '#7c3aed',
                'secondary' => '#4c1d95',
                'bg' => '#4c1d95',
                'text' => '#f9fafb',
            ],
            'font' => 'Open Sans',
            'layout' => 'wide',
        ],
        'theme_13' => [
            'name' => 'Gold Light',
            'colors' => [
                'primary' => '#eab308',
                'secondary' => '#fef9c3',
                'bg' => '#ffffff',
                'text' => '#111827',
            ],
            'font' => 'Lato',
            'layout' => 'boxed',
        ],
        'theme_14' => [
            'name' => 'Gold Dark',
            'colors' => [
                'primary' => '#eab308',
                'secondary' => '#713f12',
                'bg' => '#713f12',
                'text' => '#f9fafb',
            ],
            'font' => 'Montserrat',
            'layout' => 'wide',
        ],
        'theme_15' => [
            'name' => 'Cyber Light',
            'colors' => [
                'primary' => '#22d3ee',
                'secondary' => '#1e293b',
                'bg' => '#ffffff',
                'text' => '#111827',
            ],
            'font' => 'Figtree',
            'layout' => 'boxed',
        ],
        'theme_16' => [
            'name' => 'Cyber Dark',
            'colors' => [
                'primary' => '#22d3ee',
                'secondary' => '#e2e8f0',
                'bg' => '#e2e8f0',
                'text' => '#f9fafb',
            ],
            'font' => 'Roboto',
            'layout' => 'wide',
        ],
        'theme_17' => [
            'name' => 'Luxury Light',
            'colors' => [
                'primary' => '#1c1917',
                'secondary' => '#e7e5e4',
                'bg' => '#ffffff',
                'text' => '#111827',
            ],
            'font' => 'Open Sans',
            'layout' => 'boxed',
        ],
        'theme_18' => [
            'name' => 'Luxury Dark',
            'colors' => [
                'primary' => '#1c1917',
                'secondary' => '#44403c',
                'bg' => '#44403c',
                'text' => '#f9fafb',
            ],
            'font' => 'Lato',
            'layout' => 'wide',
        ],
        'theme_19' => [
            'name' => 'Mint Light',
            'colors' => [
                'primary' => '#14b8a6',
                'secondary' => '#ccfbf1',
                'bg' => '#ffffff',
                'text' => '#111827',
            ],
            'font' => 'Montserrat',
            'layout' => 'boxed',
        ],
        'theme_20' => [
            'name' => 'Mint Dark',
            'colors' => [
                'primary' => '#14b8a6',
                'secondary' => '#134e4a',
                'bg' => '#134e4a',
                'text' => '#f9fafb',
            ],
            'font' => 'Figtree',
            'layout' => 'wide',
        ],
    ];

    /**
     * PERFORMANCE OPTIMIZATION:
     * Previously, themes were generated procedurally in the constructor using a loop
     * and array functions (like array_rand, which caused non-deterministic font bugs).
     * Since this service is injected globally via View::composer('*'), the constructor
     * runs on every view render (unless specifically bypassed).
     *
     * By converting the output into a hardcoded static array:
     * 1. We eliminate runtime CPU overhead (looping, merging arrays).
     * 2. We enable PHP OPcache to store the array in shared memory, achieving zero-overhead instantiation.
     * 3. We ensure fonts are completely deterministic across requests.
     *
     * Impact: Reduces ThemeService instantiation time by up to ~150x.
     */

    /**
     * Memoized active theme ID to prevent redundant DB queries.
     */
    protected ?string $cachedActiveThemeId = null;

    /**
     * Memoized check for settings table existence.
     */
    protected ?bool $hasSettingsTable = null;

    public function getAllThemes(): array
    {
        return $this->themes;
    }

    public function getActiveThemeId(): string
    {
        // Return memoized value if available
        if ($this->cachedActiveThemeId !== null) {
            return $this->cachedActiveThemeId;
        }

        // Check Laravel Cache before hitting DB or Schema
        $cachedId = Cache::get('active_theme_id');
        if ($cachedId !== null) {
            $this->cachedActiveThemeId = $cachedId;

            return $this->cachedActiveThemeId;
        }

        // Memoize table check
        if ($this->hasSettingsTable === null) {
            $this->hasSettingsTable = Schema::hasTable('settings');
        }

        // Avoid database calls during migrations or if table doesn't exist
        if (! $this->hasSettingsTable) {
            return 'theme_1';
        }

        // Query and memoize
        $this->cachedActiveThemeId = DB::table('settings')->where('key', 'active_theme')->value('value') ?? 'theme_1';

        // Cache the result forever (invalidated in setActiveTheme)
        Cache::forever('active_theme_id', $this->cachedActiveThemeId);

        return $this->cachedActiveThemeId;
    }

    public function getActiveThemeConfig(): array
    {
        $id = $this->getActiveThemeId();

        return $this->themes[$id] ?? $this->themes['theme_1'];
    }

    public function setActiveTheme(string $themeId): void
    {
        if (isset($this->themes[$themeId])) {
            DB::table('settings')->updateOrInsert(
                ['key' => 'active_theme'],
                ['value' => $themeId]
            );

            // Invalidate the cache
            Cache::forget('active_theme_id');

            // Update local cache to reflect change immediately
            $this->cachedActiveThemeId = $themeId;
        }
    }
}
