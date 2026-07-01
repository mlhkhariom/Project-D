## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-03-02 - [Zero-Overhead Instantiation with Static Arrays]
**Learning:** Procedural generation of deterministic data in constructors of globally injected services (e.g., via `View::composer('*')`) adds significant initialization overhead per view render and can introduce hidden bugs if non-deterministic functions like `array_rand()` are used.
**Action:** Always replace procedural initialization of static configurations (like theme lists) with hardcoded static arrays. This eliminates constructor execution overhead and allows PHP OPcache to store the structures efficiently in shared memory.
