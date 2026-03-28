## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-02-26 - [Convert Procedural Generation to Static Array for View Composers]
**Learning:** Procedural generation within singletons injected via `View::composer('*')` leads to massive performance overhead due to instantiation processing happening continuously on each view render.
**Action:** Always prefer fully hardcoded static arrays over procedural generation in services injected frequently.
