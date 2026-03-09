## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-02-28 - [Global View Composer Constructor Overhead]
**Learning:** Code in the constructor of a service injected via `View::composer('*')` (like `ThemeService`) executes on *every* request that renders a view. If this constructor does expensive work (like procedural generation or loops), it adds overhead to all page loads, even if the result isn't needed.
**Action:** Lazy-load expensive operations inside services. Remove heavy logic from constructors and only execute it when specific methods (like `getAllThemes` or `getActiveThemeConfig` for non-default themes) are called.
