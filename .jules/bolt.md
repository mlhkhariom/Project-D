## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-02-26 - [Avoid procedural generation in singletons]
**Learning:** Procedural generation of deterministic data in constructors of globally injected services (e.g., via `View::composer("*")`) causes severe initialization overhead and non-deterministic behavior (like random font selection on every request).
**Action:** Use hardcoded static arrays for deterministic config to achieve zero-overhead instantiation.
