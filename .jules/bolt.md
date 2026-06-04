## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.
## 2026-02-26 - [Procedural Theme Generation Optimization]
**Learning:** Procedural generation of deterministic data in constructors of globally injected singleton services (like `ThemeService` injected via `View::composer('*')`) causes heavy array instantiation overhead on every request and introduces hidden bugs if non-deterministic functions (e.g. `array_rand()`) are used.
**Action:** Always prefer hardcoded static arrays for large configurations over procedural generation in constructors. This eliminates initialization time and allows PHP OPcache to store the array in shared memory.
