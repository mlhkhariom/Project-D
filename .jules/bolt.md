## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-02-26 - [OPcache Static Array Optimization in Singletons]
**Learning:** Procedurally generating deterministic configuration data in constructors of globally injected singletons (like `ThemeService` injected via `View::composer('*')`) prevents PHP OPcache from optimizing the array in shared memory. Furthermore, using non-deterministic functions like `array_rand()` during this instantiation can cause hidden UI instability across requests.
**Action:** Always replace procedural loops and non-deterministic logic in singleton constructors with hardcoded static arrays. This achieves zero-overhead instantiation and leverages OPcache to dramatically improve performance and consistency.
