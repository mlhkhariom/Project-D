## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-03-05 - [Singleton Instantiation Overhead]
**Learning:** Constructing a Laravel singleton injected via `View::composer('*')` invokes the `__construct()` method when the first view is resolved. If the constructor contains procedural generation logic (like a loop running `array_rand()`), it delays the first render significantly (e.g., from ~1ms to ~75ms per 10k runs).
**Action:** Replace procedurally generated deterministic data in constructors with hardcoded static arrays to eliminate instantiation overhead entirely.
