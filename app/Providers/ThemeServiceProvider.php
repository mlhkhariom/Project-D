<?php

namespace App\Providers;

use App\Services\ThemeService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ThemeService::class, function ($app) {
            return new ThemeService;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share the active theme config with all views
        // Using a closure to defer resolution until view rendering
        View::composer('*', function ($view) {
            $themeService = app(ThemeService::class);
            $view->with('theme', $themeService->getActiveThemeConfig());
            $view->with('theme_id', $themeService->getActiveThemeId());
        });
    }
}
