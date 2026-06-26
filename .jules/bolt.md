## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-02-26 - [Procedural Generation in Singletons]
**Learning:** Procedurally generating static data (like themes) in the constructor of a globally injected singleton (e.g., via `View::composer('*')`) introduces unnecessary overhead on every view render. Additionally, using non-deterministic functions (like `array_rand()`) during this generation causes hidden bugs where assigned values change randomly across page loads.
**Action:** Always use hardcoded static arrays for large class properties in singletons when possible. This allows PHP OPcache to store the arrays in shared memory, achieving zero-overhead instantiation and guaranteeing determinism.
