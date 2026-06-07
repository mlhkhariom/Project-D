## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-06-07 - [Procedural Generation in Global Service Constructors]
**Learning:** Procedurally generating large, deterministic data structures (like theme variations) in the constructor of a service injected globally (e.g. via `View::composer('*')`) causes unnecessary instantiation overhead on every request. This delays rendering even when the data itself is static.
**Action:** Always use hardcoded static arrays for large deterministic configurations in globally injected services to allow OPcache optimizations and ensure zero-overhead instantiation.
