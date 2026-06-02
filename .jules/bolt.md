## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-06-02 - [Procedural Generation in Globally Injected Services]
**Learning:** Procedurally generating deterministic data (e.g., using loops and `array_rand()` in a constructor) in services injected globally via `View::composer('*')` introduces significant performance overhead, as it runs upon the first view render on every request, bypassing PHP OPcache benefits and sometimes leading to hidden non-deterministic bugs.
**Action:** Always replace procedural array generation with hardcoded static arrays in globally injected singleton constructors. This allows PHP OPcache to store the arrays directly in shared memory, achieving zero-overhead instantiation.
