## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-05-01 - [Avoid Procedural Generation in Singleton Services]
**Learning:** Procedural generation of large deterministic datasets (like the 20 theme variants in `ThemeService`) within constructors of services injected globally (e.g., via `View::composer`) adds hidden runtime initialization overhead on every request. Additionally, using non-deterministic functions like `array_rand()` during such generation can introduce subtle, hard-to-track UI bugs across page loads.
**Action:** Replace procedural generation logic in constructors with hardcoded static arrays. This eliminates the initialization cost entirely and allows PHP OPcache to store the array in shared memory for zero-overhead access.
