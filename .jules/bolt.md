## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2023-10-27 - [Singleton Initialization Overhead]
**Learning:** Generating deterministic data procedurally inside the constructor of globally injected singleton services (like `ThemeService`) introduces unnecessary runtime initialization overhead on every cold request.
**Action:** Always replace procedural static data generation in singleton constructors with hardcoded static arrays to eliminate instantiation time and utilize PHP OPcache efficiently.
