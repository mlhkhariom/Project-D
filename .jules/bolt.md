## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.
## 2026-02-27 - [Singleton Constructor Initialization Overhead]
**Learning:** In globally injected singletons (e.g., via `View::composer('*')`), any procedural generation within the constructor executes once per request. Constructing large configuration arrays dynamically (especially using non-deterministic functions like `array_rand`) introduces initialization overhead and potential bugs.
**Action:** Replace procedural array generation with hardcoded static arrays in globally injected services to eliminate initialization overhead and ensure deterministic values.
