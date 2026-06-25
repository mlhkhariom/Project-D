## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-02-26 - [Runtime Array Generation in Singletons]
**Learning:** Procedurally generating complex arrays (like themes) with functions like `array_rand()` inside the `__construct()` of a globally injected singleton (e.g., via `View::composer('*')`) causes unnecessary O(n) initialization overhead on every request and introduces non-deterministic bugs (e.g., fonts changing randomly on reload).
**Action:** Always prefer statically defined, hardcoded arrays for configuration data within services. This allows PHP OPcache to store the structure in shared memory, achieving zero-overhead instantiation and guaranteeing determinism.
