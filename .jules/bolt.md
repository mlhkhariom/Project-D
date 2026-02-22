## 2026-02-05 - N+1 Issue in Theme Service
**Learning:** `View::composer('*')` triggers for every partial view. Service methods called within it must be memoized.
**Action:** Memoize `getActiveThemeId` and `Schema::hasTable` in `ThemeService` to prevent repeated DB queries per request.
