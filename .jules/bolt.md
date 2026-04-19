## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.
## 2026-02-26 - [Zero-Overhead View Composers]
**Learning:** Procedural generation of static arrays inside the constructor of globally injected singletons (e.g., `View::composer('*')`) introduces unnecessary CPU and memory allocation overhead on every initial resolution per request, and using non-deterministic functions like `array_rand()` can cause subtle layout bugs.
**Action:** Always prefer statically defined, hardcoded arrays for configuration data within injected services to achieve zero-overhead instantiation and ensure deterministic rendering.
