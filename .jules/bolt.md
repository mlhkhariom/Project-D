## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-05-27 - [Procedural Generation in Globally Injected Services]
**Learning:** Generating deterministic data procedurally inside the constructor of a service that is globally injected via `View::composer('*')` (like `ThemeService`) creates a substantial per-request overhead that scales with the number of partial views rendered. Using non-deterministic functions (like `array_rand()`) during this procedural generation also introduces subtle bugs where the result differs per instantiation.
**Action:** Replace procedurally generated static data within globally injected singleton constructors with hardcoded static arrays. This allows PHP OPcache to store the arrays efficiently in shared memory, achieving zero-overhead instantiation and guaranteeing determinism.
