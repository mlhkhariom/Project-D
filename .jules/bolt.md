## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.
## 2025-05-21 - [ThemeService Initialization Overhead]
**Learning:** Procedural generation of deterministic data inside globally injected singleton constructors (like `ThemeService` injected via `View::composer('*')`) causes unnecessary execution overhead and, if non-deterministic functions like `array_rand()` are used, leads to subtle UI inconsistency bugs across requests.
**Action:** Always pre-compute and hardcode static configuration arrays so PHP OPcache can store them in shared memory for ~O(1) initialization.
