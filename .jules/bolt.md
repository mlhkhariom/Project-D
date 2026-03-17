## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2025-02-13 - Lazy-Loading in Global View Composers
**Learning:** Computations inside the constructors of singleton services injected via global View Composers (e.g., `View::composer('*')`) execute upon the first view render per request. If these computations (like procedural generation) are expensive and not lazy-loaded, they create unnecessary overhead on every request that renders a view, even if the result isn't always needed immediately.
**Action:** Always lazy-load expensive computations in singleton services injected via View Composers. Delay the execution until the specific data is actually requested by a method call.
