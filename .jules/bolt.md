## 2024-05-24 - ThemeService Memoization
**Learning:** `Schema::hasTable` and `DB::table` calls in a global View Composer (`View::composer('*')`) cause significant N+1 issues (e.g., 12 queries for a simple page) because they run for every partial view.
**Action:** Always memoize results in singleton services that are injected into global view composers. Added `$cachedActiveThemeId` and `$hasSettingsTable` to `ThemeService` to reduce queries to <= 2 per request. Verified with `tests/Feature/ThemePerformanceTest.php`.
