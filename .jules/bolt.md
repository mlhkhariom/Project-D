## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-05-12 - [Hardcoded Static Array vs Procedural Generation]
**Learning:** Procedural generation of data (like theme configuration via looping over palettes and calling `array_rand`) within globally injected singleton constructors creates a bottleneck. In PHP, hardcoded static arrays can be cached in shared memory via OPcache, drastically reducing class instantiation overhead from ~7.5ms to ~0.26ms. Furthermore, `array_rand()` generates non-deterministic data, which breaks caching concepts and can lead to bugs (e.g. font changing randomly).
**Action:** Always prefer statically defined, hardcoded arrays over procedural generation loops for class properties that serve as read-only configurations, especially in globally instantiated singletons.
