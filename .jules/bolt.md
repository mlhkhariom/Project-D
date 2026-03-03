## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-03-03 - [Caching Schema Table Existence in SQLite]
**Learning:** `Schema::hasTable` operations in SQLite trigger queries against `sqlite_master`. These operations are expensive and not automatically cached. Since `ThemeService` relies on this to fail gracefully when `settings` table doesn't exist, this leads to an unnecessary schema query on the hot path.
**Action:** Use application-level caching (like Laravel's `Cache` facade) to store the result of values that depend on `Schema::hasTable` checks so we can completely bypass them on subsequent requests, drastically reducing database overhead on the cold path.
