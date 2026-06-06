## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-03-02 - [Optimizing Dynamic Singleton Initialization]
**Learning:** Proceeding to generate static data (e.g., using `array_rand()` or loops) dynamically in the constructor of a globally injected singleton (like `ThemeService`) imposes completely unnecessary runtime initialization overhead and introduces hidden non-deterministic bugs (fonts changing every request).
**Action:** Always favor storing static configuration data as hardcoded property arrays in PHP to take advantage of OPcache's shared memory storage, which leads to zero runtime initialization overhead.
