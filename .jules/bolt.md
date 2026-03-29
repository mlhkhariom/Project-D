## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.
## 2026-03-29 - [ThemeService Constructor Optimization]
**Learning:** Procedural generation of static arrays (e.g., themes) in a globally injected service constructor (`View::composer('*')`) causes unnecessary execution overhead on every partial view render.
**Action:** Always pre-compute and hardcode procedural arrays for deterministic data directly in the class properties rather than generating them during instantiation.
