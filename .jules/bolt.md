## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-05-07 - [Static Array vs Procedural Generation for Singletons]
**Learning:** Procedural generation of large deterministic arrays in the constructor of a globally injected singleton (like `ThemeService` injected via `View::composer('*')`) adds significant overhead to the initial instantiation on every request. Converting this to a hardcoded static array allows PHP OPcache to store the array in shared memory, eliminating runtime initialization overhead and achieving a significant instantiation time reduction.
**Action:** Use hardcoded static arrays instead of procedural generation for deterministic data in globally injected service constructors for zero-overhead instantiation.
