## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-02-05 - Optimize Singleton Initialization
**Learning:** In Laravel, singletons injected via global View Composers (e.g., `View::composer('*')`) are initialized on the first view render of a request. Procedural data generation (like looping through arrays to generate configuration data) inside the constructor of such a service adds unnecessary overhead to every request, even if the result is deterministic.
**Action:** Always pre-calculate deterministic data and hardcode it as static arrays or constants to eliminate initialization overhead, especially for services instantiated frequently or on critical paths like view rendering.
