## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-06-22 - [Singleton Instantiation Overhead]
**Learning:** Procedurally generating deterministic arrays (e.g., using `array_rand()` in a loop) inside the constructor of globally injected singletons causes significant hidden overhead (~150x slower instantiation), especially when these singletons are resolved frequently via `View::composer('*')` on every view render.
**Action:** Always replace procedural array generation with hardcoded static arrays for large configurations in service layers to ensure zero-overhead instantiation and deterministic output.
