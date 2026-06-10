## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-02-26 - [Avoid Procedural Generation in Singleton Constructors]
**Learning:** Generating deterministic data procedurally (e.g. via arrays/loops) within the constructor of a globally injected singleton (like `ThemeService` injected via `View::composer`) incurs significant initialization overhead on every request. Even worse, if it relies on non-deterministic functions (like `array_rand`), it can cause UI inconsistencies.
**Action:** Always replace procedural initialization of static configurations with hardcoded static arrays. Hardcoded arrays are stored in shared memory by PHP OPcache, eliminating instantiation overhead and ensuring consistent behavior.
