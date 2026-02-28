## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2025-02-28 - [SQLite Schema Checking Performance]
**Learning:** `Schema::hasTable()` queries `sqlite_master` in SQLite. Laravel doesn't cache the result across requests natively. When used in high-frequency locations like `View::composer('*')` (which executes for every view rendered), it triggers repeated database queries for the table schema even if it never changes, destroying performance.
**Action:** When executing schema checks (`Schema::hasTable`) in performance-critical or frequently accessed paths, explicitly wrap them in a persistent cache like `Cache::rememberForever()` to avoid redundant queries to `sqlite_master`.
