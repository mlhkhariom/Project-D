## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-05-26 - [Procedural Generation in Global Singletons]
**Learning:** Procedural generation of deterministic data (e.g., iterating to build a theme array) in constructors of globally injected services (like those registered in `View::composer('*')`) adds measurable overhead on every request. Furthermore, using functions like `array_rand()` during this instantiation can cause insidious, non-deterministic bugs across renders.
**Action:** Always prefer hardcoded static arrays or pre-computed structures over runtime procedural generation for global singletons, especially those invoked frequently or injected broadly.
