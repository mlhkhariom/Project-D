## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-03-02 - [Deterministic Data in Singleton Services]
**Learning:** Procedural generation of large deterministic datasets (like 20+ themes using loops and `array_rand()`) inside the constructor of a singleton service creates significant per-request instantiation overhead and hidden bugs (non-deterministic font changes across page loads).
**Action:** Always use hardcoded static arrays for large deterministic config/theme data. This eliminates runtime initialization overhead, allows PHP OPcache to store the array in shared memory efficiently, and ensures strict determinism across page renders.
