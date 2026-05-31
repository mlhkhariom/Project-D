## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-05-31 - [ThemeService Initialization Performance Trap]
**Learning:** Using procedural generation (especially with `array_rand()`) in the constructor of a globally injected singleton like `ThemeService` causes severe hidden overhead during application bootstrapping. Every request dynamically builds an array when static generation is far faster. PHP OPcache can natively store static arrays in shared memory, preventing this runtime cost.
**Action:** Always avoid procedural generation of deterministic configuration data. Use hardcoded static arrays instead, especially inside singletons or global view composers.
