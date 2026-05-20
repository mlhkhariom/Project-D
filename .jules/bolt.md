## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2024-05-20 - Procedural Generation in Singletons
**Learning:** Proceedurally generating array properties (using loops and non-deterministic functions like `array_rand()`) inside the constructor of a service bound as a singleton and injected globally via `View::composer('*')` introduces unnecessary CPU overhead and subtle state bugs (like changing fonts).
**Action:** Always use statically hardcoded arrays or cached configurations for globally injected services to leverage OPcache and ensure deterministic, zero-overhead instantiation.
