## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2023-10-27 - [Singleton Constructor Overhead in Global View Composers]
**Learning:** Instantiating services inside `View::composer('*')` triggers their constructors on the first view render per request. If the constructor contains heavy logic (like generating procedural themes), it executes unnecessarily even if the properties aren't used in that specific view, adding significant overhead.
**Action:** Always lazy-load expensive computations or data generation in singleton services rather than placing them directly in the `__construct()` method, ensuring they are only computed when actually needed.
