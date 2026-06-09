## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-02-26 - [Procedural Generation in Global Singletons]
**Learning:** Procedural generation of static array data (e.g., using loops and `array_rand()`) inside constructors of globally injected singletons (like `ThemeService` via `View::composer('*')`) causes unnecessary execution overhead. Even small operations take time, and they execute once per request when the singleton is first resolved.
**Action:** Replace procedural generation of deterministic data in global service constructors with hardcoded static arrays. This ensures zero-overhead instantiation and allows PHP OPcache to efficiently store the arrays in shared memory.
