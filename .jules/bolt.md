## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-02-26 - [Procedural Generation Overhead in Constructors]
**Learning:** Using `generateProceduralThemes()` inside the `ThemeService` constructor creates completely unnecessary runtime overhead. Because `ThemeService` is instantiated on every single request, this loop executes thousands of times an hour on a busy server, performing string concatenations, array manipulations, and even `array_rand()` which introduces non-deterministic bugs (fonts randomly changing on page load).
**Action:** Always prefer statically defined data structures (like hardcoded arrays) over procedural runtime generation for configuration data. PHP's OPcache can store static arrays directly in shared memory, reducing instantiation overhead to essentially zero.
