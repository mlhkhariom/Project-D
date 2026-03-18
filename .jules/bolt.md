## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-03-05 - [Lazy Loading Procedural Data in View Composers]
**Learning:** Computations placed in the constructor of a singleton service that is injected via a global `View::composer('*')` execute synchronously. If that logic involves expensive procedural generation or processing, it drastically increases overhead for every request, even if the result isn't always needed by the view.
**Action:** Always lazy-load expensive computations or procedural data generation within services. Initialize them via an `ensureDataGenerated()`-style method that is called only when the specific data is requested by a getter.
