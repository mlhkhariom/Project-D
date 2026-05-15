## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-05-15 - [Static Data Generation Overhead in Constructors]
**Learning:** Procedural generation of static deterministic data (like themes) in a singleton constructor or globally injected service adds unnecessary overhead per instantiation and risks non-determinism (e.g., using `array_rand`). Hardcoding this data as an array allows PHP OPcache to store the array in shared memory, achieving near-zero initialization cost (~100x+ faster instantiation in this case).
**Action:** Always prefer hardcoded static arrays over procedural loops for defining constant configuration objects inside frequently instantiated classes.
