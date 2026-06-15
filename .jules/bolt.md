## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-02-26 - [Avoid Procedural Generation in Singleton Services]
**Learning:** Generating deterministic data (like themes) procedurally inside the `__construct()` of globally injected services (via `View::composer('*')`) adds measurable CPU overhead and blocks the main thread on every request, even if database queries are memoized. Furthermore, using `array_rand()` during this phase creates non-deterministic bugs across renders.
**Action:** Always prefer hardcoded static arrays (which OPcache optimizes into shared memory) over runtime procedural generation for fixed configuration data to eliminate initialization overhead and guarantee determinism.
