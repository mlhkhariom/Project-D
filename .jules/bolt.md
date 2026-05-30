## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-05-30 - [ThemeService Initialization Performance Trap]
**Learning:** Procedurally generating large configuration arrays (e.g., iterating through colors and fonts with loops and `array_rand`) inside the constructor of a globally injected singleton (like `ThemeService` injected via `View::composer('*')`) adds significant overhead because the initialization happens dynamically at runtime.
**Action:** Always prefer defining large, static configuration arrays as hardcoded class properties. This completely eliminates runtime initialization overhead by allowing PHP OPcache to store and serve the array directly from shared memory.
