## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.
## 2026-03-02 - [Avoid Procedural Generation in Singleton Services]
**Learning:** Initializing large data structures procedurally (e.g., in a `__construct()` method) inside globally injected singleton services causes unnecessary CPU overhead on every request. PHP's OPcache can optimize static, hardcoded arrays by storing them in shared memory, making their retrieval virtually zero-cost.
**Action:** Always prefer hardcoded static arrays over procedural generation in service classes, especially those injected globally via view composers.
