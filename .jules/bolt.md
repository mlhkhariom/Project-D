## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-02-26 - [OPcache Optimization for Static Arrays]
**Learning:** Procedural generation of large arrays (like themes) in a globally injected service's constructor causes significant initialization overhead and potential bugs (like non-deterministic font rendering if `array_rand()` is used). Hardcoding these generated arrays directly into the class property allows PHP's OPcache to load the structure instantly in shared memory.
**Action:** Always prefer statically defined data structures over procedural generation for data that does not change at runtime. Run static analysis tools to verify the generated structure is properly converted.
