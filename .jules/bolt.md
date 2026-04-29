## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-04-29 - [ThemeService Instantiation Overhead]
**Learning:** Procedurally generating large configuration arrays (like theme variants) inside the constructor of a globally injected singleton service (e.g., via `View::composer('*')`) incurs unnecessary CPU overhead on every request/view render. It also creates non-deterministic bugs if random functions like `array_rand()` are used to generate static configurations.
**Action:** Replace procedural generation logic in constructors with hardcoded, static properties. This allows OPcache to store the array in shared memory, making instantiation instantaneous and ensuring deterministic configurations.
