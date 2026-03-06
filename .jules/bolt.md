## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-03-06 - [Constructor Overhead in Global View Composers]
**Learning:** Instantiating services in global View Composers `View::composer('*')` executes their constructors on *every* view render. If the constructor contains computationally expensive logic (e.g., procedural asset generation), it will severely bloat rendering times, even if the result isn't fully used.
**Action:** Use lazy loading (deferred execution) for expensive operations inside services that are bound to global view composers. Only generate or calculate data when explicitly requested via a getter method.
