## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.
## 2026-02-26 - [Procedural Generation in Singletons]
**Learning:** Procedurally generating static data (like themes) in the constructor of a globally injected singleton adds massive overhead because it runs once per request when the view composer triggers it.
**Action:** Use hardcoded static arrays for deterministic data when possible. They can be optimized by PHP OPcache and have zero initialization overhead compared to procedural loops with `array_rand`.
