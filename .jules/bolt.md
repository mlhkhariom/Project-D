## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-05-08 - [Procedural Object Instantiation Cost in Global View Composers]
**Learning:** Procedural generation of deterministic static data in the constructor of a service that is globally injected via `View::composer('*')` leads to massive instantiation overhead. Even if only done once per request on first view render, looping arrays and using functions like `array_rand()` inside a constructor adds unnecessary compute time.
**Action:** Convert procedural array generation for deterministic structures (like default themes) into hardcoded static arrays. This ensures zero-overhead instantiation and deterministic properties (fixing bugs where properties would change randomly on refresh).
