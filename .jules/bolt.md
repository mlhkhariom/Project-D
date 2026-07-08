## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-03-02 - [Zero-Overhead Instantiation for Singletons]
**Learning:** Procedural generation of deterministic data in constructors of globally injected singletons (e.g., `ThemeService` injected via `View::composer('*')`) incurs unnecessary runtime overhead and can introduce subtle bugs if non-deterministic functions (like `array_rand`) are used.
**Action:** Always define large class properties (like theme configurations) using hardcoded static arrays. This allows PHP OPcache to store the arrays in shared memory, achieving zero-overhead instantiation and guaranteeing deterministic behavior.
