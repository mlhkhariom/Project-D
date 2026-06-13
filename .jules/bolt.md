## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-06-13 - [PHP OPcache and Procedural Generation]
**Learning:** Procedural generation of large arrays or data structures in the constructor of a globally injected singleton (e.g. `ThemeService` injected via `View::composer('*')`) incurs a runtime initialization cost for every request, and may result in hidden non-deterministic bugs (like random font selection).
**Action:** Replace dynamically generated properties with hardcoded static arrays where feasible. This eliminates initialization overhead by allowing PHP's OPcache to store the array in shared memory, making the instantiation near-instantaneous.
