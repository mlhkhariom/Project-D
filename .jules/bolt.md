## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2024-07-04 - Eliminate procedural configuration generation in globally injected services
**Learning:** Procedural generation of deterministic data (like arrays or objects) inside the constructor of a service that is globally injected via `View::composer('*')` leads to massive overhead since it executes on the first view render of every request. Using `array_rand()` within this procedural logic can also lead to hidden bugs and non-deterministic behavior on every request.
**Action:** Replace procedural generation of static configurations in singleton or globally injected services with hardcoded static arrays. This allows PHP OPcache to store the array in shared memory, achieving deterministic behavior and completely eliminating instantiation overhead.
