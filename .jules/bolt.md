## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-03-05 - [ThemeService Procedural Generation Overhead]
**Learning:** Procedural generation of data (like themes) inside service constructors using loops and `array_rand()` adds unnecessary instantiation overhead, especially when services are resolved often or injected broadly (e.g. `View::composer('*')`). Using `array_rand()` also makes the results non-deterministic if not explicitly seeded or cached correctly across different requests.
**Action:** Always prefer statically defined configuration arrays over procedural runtime generation for static/predictable sets of data to completely eliminate instantiation costs and ensure deterministic outputs.
