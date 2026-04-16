## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.
## 2024-04-16 - [Singleton Instantiation Overhead in View Composers]
**Learning:** Services injected via `View::composer('*')` execute their constructors frequently. If they contain procedural logic (like looping to generate arrays and using `array_rand()`), it causes unnecessary instantiation overhead and non-deterministic behavior on every view render.
**Action:** Always replace dynamic, procedural data generation in global singleton constructors with statically defined hardcoded arrays to achieve zero-overhead instantiation and deterministic outcomes.
