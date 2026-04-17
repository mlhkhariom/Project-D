## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.
## 2026-04-17 - [Service Initialization Overhead with Dynamic Loops]
**Learning:** Initializing services with procedural generation inside the `__construct()` method can be incredibly slow, especially if that service is injected globally (e.g., via `View::composer('*')`). Doing this caused large overhead across every partial view rendered.
**Action:** Replace procedural generation loops in the constructor with statically defined/hardcoded arrays. This removes the initialization overhead completely, leading to significant performance gains (e.g., a ~150x reduction in instantiation time).
