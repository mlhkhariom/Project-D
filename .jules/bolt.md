## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-02-26 - [OPcache Static Array Over Procedural Constructors]
**Learning:** Instantiating a service injected via `View::composer('*')` triggers its constructor on every request (the first time a view is rendered). If the constructor procedurally generates large data structures (like 20 theme palettes) and uses `array_rand()`, it not only adds runtime CPU overhead but also introduces hidden non-determinism bugs across page loads.
**Action:** Always prefer hardcoded static array properties over procedural generation in globally scoped constructors. This eliminates initialization overhead and allows PHP OPcache to store the structure directly in shared memory.
