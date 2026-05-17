## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.
## 2026-02-26 - [ThemeService Procedural Generation Bug]
**Learning:** Using non-deterministic procedural generation like `array_rand()` in a singleton service constructor is a severe trap. It forces repetitive execution if the object is instanced multiple times, but more critically, causes inconsistent random UI behavior if memoized or instanced differently in production.
**Action:** Always replace procedural arrays with hardcoded static properties to ensure zero initialization overhead and Opcache sharing.
