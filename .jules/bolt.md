## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-02-26 - [Bypassing Schema Checks on Warm Cache]
**Learning:** Even with property memoization to fix N+1 queries within a single request, `ThemeService` still queried the `settings` and `sqlite_master` tables on *every new request* due to `Schema::hasTable` not being cached across requests.
**Action:** Always put application-level caching (`Cache::get`, `Cache::rememberForever`) *before* structural DB checks like `Schema::hasTable` when reading frequently accessed, rarely changed global settings, falling back to schema checks only on a cold cache miss.
