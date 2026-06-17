## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.


## 2026-02-27 - [Procedural Generation in Singletons]
**Learning:** Procedural generation (e.g. loops, `array_rand`) of large data structures in singleton constructors causes severe initialization overhead (up to ~150x slower) even when resolved once per request. It also introduces non-deterministic UI bugs if not properly seeded.
**Action:** Always replace procedural data generation in singletons/service providers with hardcoded static arrays to leverage PHP OPcache for zero-overhead instantiation and ensure determinism.
