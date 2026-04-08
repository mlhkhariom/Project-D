## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-04-08 - [Zero-Overhead View Composers]
**Learning:** Procedural generation of static deterministic data (like colors and arrays) in singleton service constructors (`ThemeService`) globally injected into views using `View::composer('*')` causes massive runtime overhead since Laravel resolves it synchronously before rendering any view. Converting procedurally generated configuration logic into static hardcoded arrays achieved a ~150x initialization performance improvement and ensures deterministic values (e.g. font picking).
**Action:** Audit globally injected singleton constructor methods for large procedural logic blocks. Prefer hardcoded static arrays to ensure zero-overhead instantiation.
