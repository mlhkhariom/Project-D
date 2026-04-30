## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-02-26 - [Procedural Array Generation in Singleton Services]
**Learning:** Procedurally generating static data (like theme configurations) inside the constructor of a service that is instantiated on every request (e.g., via `View::composer('*')` when not fully memoized or bound as a deferred singleton properly) incurs a significant performance overhead and prevents PHP OPcache from optimizing the array structure. Additionally, using non-deterministic functions like `array_rand()` during such generation can cause hidden bugs and test flakiness.
**Action:** Always use hardcoded static arrays for predefined configurations instead of procedural generation to allow PHP OPcache to store the array in shared memory, achieving zero-overhead instantiation and guaranteeing determinism.
