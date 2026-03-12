## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-03-12 - [Lazy Loading Procedural Data in Singletons]
**Learning:** Instantiating objects globally via `View::composer('*')` in Service Providers forces heavy setup operations (like procedural theme generation) to run unnecessarily on every request that renders a view, even if the request only requires static data. Although Laravel memoizes the singleton for the request, constructing it is still a significant overhead (~0.007ms down to ~0.0001ms after optimization).
**Action:** When creating Singletons or Service objects injected globally, always defer heavy initialization loops/computations into dedicated methods (e.g., `ensureThemesGenerated()`) and call them lazily only when strictly necessary within getter methods.
