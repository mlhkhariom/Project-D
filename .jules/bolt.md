## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-02-26 - [OPCache vs Procedural Instantiation]
**Learning:** Generating large deterministic arrays procedurally in constructors (especially using `array_rand()`) creates unnecessary runtime overhead and causes non-deterministic bugs (like fonts changing on every request) when the service is instantiated.
**Action:** Always prefer hardcoded static arrays for deterministic data structures. This allows PHP's OPcache to store the array in shared memory, reducing instantiation time to near zero and ensuring consistency.
