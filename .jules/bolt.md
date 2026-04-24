## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.
## 2026-02-26 - [Procedural Generation in Singleton Constructors]
**Learning:** Initializing globally injected singletons (like `ThemeService`) with procedural loops and non-deterministic logic (e.g., `array_rand()`) creates unnecessary instantiation overhead and can lead to UI bugs where elements randomly change across loads or cache clears.
**Action:** Replace procedural configuration generation with hardcoded, deterministic static arrays within the class. This eliminates computational overhead entirely, allowing PHP's OPcache to store the configuration efficiently.
