## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-04-03 - [Constructor Overhead in View Composers]
**Learning:** Classes that are resolved inside a global `View::composer('*')` are instantiated upon the *first* view render for *every* request. If that constructor has procedural loops or expensive arrays (e.g., generating 20 themes), that cost is incurred per request, defeating OPcache which can only optimize static properties, not dynamic generation.
**Action:** Move deterministically generated data in constructors to hardcoded static properties/arrays. Use scratchpad scripts to generate the code once, then paste it in, avoiding runtime CPU overhead.
