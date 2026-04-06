## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-02-28 - [Singleton Procedural Overhead]
**Learning:** Constructing singletons with procedural logic inside (especially ones loaded globally via `View::composer`) adds initialization overhead that slows down every initial application render or view composition, scaling poorly and adding jitter.
**Action:** For finite, determinable configurations (like theme data), strictly use static hardcoded arrays over procedural loop generation to achieve zero-overhead object instantiation.
