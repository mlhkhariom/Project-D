## 2024-05-23 - ThemeService Memoization
**Learning:** `Schema::hasTable` in SQLite triggers a database query (`select exists (select 1 from sqlite_master...)`) and is NOT automatically cached per request by Laravel. Calling it repeatedly in a View Composer causes massive N+1 issues (1262 queries for a simple page load).
**Action:** Always memoize the result of schema checks (or the fallback value) in service classes that are injected into view composers or frequently called paths.
