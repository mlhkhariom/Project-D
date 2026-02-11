<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ThemeServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_theme_query_is_cached()
    {
        DB::enableQueryLog();

        $this->get('/');

        $log = DB::getQueryLog();

        $settingsQueries = collect($log)->filter(function ($query) {
            return str_contains($query['query'], 'settings')
                && collect($query['bindings'])->contains('active_theme');
        });

        $this->assertLessThanOrEqual(1, $settingsQueries->count(), 'Theme settings query should be cached and not repeated.');
    }
}
