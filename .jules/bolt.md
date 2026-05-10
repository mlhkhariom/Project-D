## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.
## 2026-05-10 - [Global View Composer Performance Trap Optimization]
**Learning:** The `$themes` array in `ThemeService` was being populated via a procedural generation loop using `array_rand()`, which resulted in non-deterministic font assignment across page reloads and slow initialization overhead since `ThemeService` is instantiated on the first view render via a global `View::composer('*')`.
**Action:** Replace procedural configuration logic in constructors or service layers with hardcoded static arrays where possible. This enables OPcache sharing and removes instantiation overhead.
