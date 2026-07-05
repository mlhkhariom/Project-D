## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-02-26 - [Zero-Overhead Instantiation with Static Arrays]
**Learning:** Procedural generation of static deterministic data in constructors of globally injected services (e.g., via `View::composer('*')`) introduces unnecessary overhead on every page load. Furthermore, if non-deterministic functions like `array_rand()` are used, they can cause bugs like random UI changes across reloads.
**Action:** Replace procedural generation logic in constructors with hardcoded static arrays. This allows PHP OPcache to store the structures in shared memory, resulting in zero-overhead instantiation and eliminating runtime generation cost.
