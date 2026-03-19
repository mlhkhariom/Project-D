## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-03-19 - [Global View Composer Singleton Constructor Overhead]
**Learning:** Services injected via `View::composer('*')` execute their constructor logic once per request whenever the first view is rendered. If a service (like `ThemeService`) performs expensive procedural generation or dynamic array building in its constructor, this overhead is incurred on every single request.
**Action:** Always avoid procedural generation or heavy operations in constructors of singletons that are resolved frequently (e.g. via view composers or middleware). Use hardcoded static arrays where possible or defer complex initializations until the specific data is actually needed (lazy loading).
