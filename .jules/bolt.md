## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2025-03-15 - [Singleton Construction Overhead vs Lazy Evaluation]
**Learning:** Constructors of singleton services injected via global View Composers (e.g., `ThemeService` injected in `View::composer('*')`) execute once per request upon the first view render. Heavy computations inside them (like procedural generation) must be lazy-loaded to prevent unnecessary overhead. Previously, the `ThemeService` generated themes on initialization, which caused overhead regardless of whether the themes config was actually used in the rendered subview.
**Action:** Use a lazy evaluation pattern (e.g. `ensureThemesGenerated()` method called by accessor methods `getAllThemes`, `getActiveThemeConfig`) to defer the heavy work until exactly when the data is accessed.
