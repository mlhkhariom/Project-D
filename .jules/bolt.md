## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-05-16 - [Procedural Generation in Singletons]
**Learning:** Generating large data structures procedurally (like theme arrays using `array_rand`) inside a globally injected service's constructor defeats OPcache optimizations and introduces non-deterministic behavior on every request.
**Action:** Replace procedural generation of static data with hardcoded arrays. This allows PHP's OPcache to store the structure in shared memory, achieving significant speedups and ensuring consistency across requests.
