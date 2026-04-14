## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.
## 2026-02-26 - [Singleton Service Initialization Overhead]
**Learning:** Services registered as singletons and resolved via `View::composer(*)` execute their `__construct` method logic (such as procedural data generation) during the first resolution per request. Procedural generation (e.g., loops and non-deterministic functions like `array_rand`) can introduce significant overhead (e.g., 0.0075s vs 0.0002s for 1000 iterations).
**Action:** Replace procedural generation in injected singleton constructors with hardcoded static arrays where possible to eliminate initialization overhead.
