## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2024-04-01 - [ThemeService Constructor Optimization]
**Learning:** Procedural generation of deterministic data inside the constructor of globally injected services (e.g. `ThemeService` injected via `View::composer('*')`) can introduce unnecessary instantiation overhead and non-deterministic behavior (like random font selection).
**Action:** Always favor hardcoded static data structures over procedural generation when the output is constant, especially for services instantiated frequently or on every view render.
