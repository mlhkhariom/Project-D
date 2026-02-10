<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;

class ThemeService
{
    private ?string $activeThemeId = null;

    protected array $themes = [
        'theme_1' => [
            'name' => 'Default (Clean)',
            'colors' => [
                'primary' => '#3b82f6', // blue-500
                'secondary' => '#64748b', // slate-500
                'bg' => '#f3f4f6', // gray-100
                'text' => '#1f2937', // gray-800
            ],
            'font' => 'Figtree',
            'layout' => 'standard',
        ],
        'theme_2' => [
            'name' => 'Midnight (Dark)',
            'colors' => [
                'primary' => '#6366f1', // indigo-500
                'secondary' => '#94a3b8', // slate-400
                'bg' => '#0f172a', // slate-900
                'text' => '#f8fafc', // slate-50
            ],
            'font' => 'Inter',
            'layout' => 'standard',
        ],
        // I will generate 18 more procedural variants
    ];

    public function __construct()
    {
        // Generate the rest of the 20 themes procedurally
        $this->generateProceduralThemes();
    }

    protected function generateProceduralThemes()
    {
        $palettes = [
            'Nature' => ['#16a34a', '#dcfce7', '#f0fdf4', '#14532d'],
            'Ocean' => ['#0ea5e9', '#e0f2fe', '#f0f9ff', '#0c4a6e'],
            'Sunset' => ['#f97316', '#ffedd5', '#fff7ed', '#7c2d12'],
            'Berry' => ['#db2777', '#fce7f3', '#fdf2f8', '#831843'],
            'Royal' => ['#7c3aed', '#ede9fe', '#f5f3ff', '#4c1d95'],
            'Gold' => ['#eab308', '#fef9c3', '#fefce8', '#713f12'],
            'Cyber' => ['#22d3ee', '#1e293b', '#0f172a', '#e2e8f0'],
            'Luxury' => ['#1c1917', '#e7e5e4', '#fafaf9', '#44403c'],
            'Mint' => ['#14b8a6', '#ccfbf1', '#f0fdfa', '#134e4a'],
        ];

        $fonts = ['Figtree', 'Roboto', 'Open Sans', 'Lato', 'Montserrat'];

        $i = 3;
        foreach ($palettes as $name => $colors) {
             $this->themes["theme_{$i}"] = [
                'name' => "$name Light",
                'colors' => [
                    'primary' => $colors[0],
                    'secondary' => $colors[1],
                    'bg' => '#ffffff',
                    'text' => '#111827',
                ],
                'font' => $fonts[array_rand($fonts)],
                'layout' => 'boxed',
            ];
            $i++;

            $this->themes["theme_{$i}"] = [
                'name' => "$name Dark",
                'colors' => [
                    'primary' => $colors[0],
                    'secondary' => $colors[3],
                    'bg' => $colors[3], // Dark bg
                    'text' => '#f9fafb',
                ],
                'font' => $fonts[array_rand($fonts)],
                'layout' => 'wide',
            ];
            $i++;
        }
    }

    public function getAllThemes(): array
    {
        return $this->themes;
    }

    public function getActiveThemeId(): string
    {
        if ($this->activeThemeId) {
            return $this->activeThemeId;
        }

        $this->activeThemeId = Cache::rememberForever('active_theme', function () {
            // Avoid database calls during migrations or if table doesn't exist
            if (!Schema::hasTable('settings')) {
                return 'theme_1';
            }

            return DB::table('settings')->where('key', 'active_theme')->value('value') ?? 'theme_1';
        });

        return $this->activeThemeId;
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

            Cache::forget('active_theme');
            $this->activeThemeId = $themeId;
        }
    }
}
