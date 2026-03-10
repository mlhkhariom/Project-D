## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-02-26 - [Lazy Loading Procedural Theme Generation]
**Learning:** Computations inside constructors of singleton services injected via global View Composers (like `ThemeService`) execute once per request upon the first view render. Eagerly generating procedural data causes unnecessary overhead on every request, especially if the generated data isn't even used (e.g., when the default theme is active).
**Action:** Always lazy-load heavy computations in services instead of running them in the constructor, particularly when they might not be needed by the current state.
