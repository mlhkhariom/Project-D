<?php

namespace App\Livewire\SuperAdmin;

use Livewire\Component;
use App\Services\ThemeService;

class Themes extends Component
{
    public $activeThemeId;
    public $themes = [];

    public function mount(ThemeService $themeService)
    {
        $this->activeThemeId = $themeService->getActiveThemeId();
        $this->themes = $themeService->getAllThemes();
    }

    public function activateTheme($themeId)
    {
        $themeService = app(ThemeService::class);
        $themeService->setActiveTheme($themeId);
        $this->activeThemeId = $themeId;

        $this->dispatch('theme-activated');
    }

    public function render()
    {
        return view('livewire.super-admin.themes')->layout('layouts.superadmin');
    }
}
