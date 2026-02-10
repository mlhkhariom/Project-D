## 2026-02-05 - Global View Composers with Database Calls
**Learning:** `View::composer('*', ...)` executes for *every* rendered view, including partials and components. In this project, `ThemeService::getActiveThemeId()` was called in a global composer, causing N+1 database queries (once per view rendered).
**Action:** When using global view composers, ensure the data source is memoized (request-scoped) or cached (application-scoped) to prevent redundant database queries. Singleton services injected into composers MUST implement internal memoization.
