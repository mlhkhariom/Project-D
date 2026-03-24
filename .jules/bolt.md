## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-03-24 - [Procedural Generation Overhead in Constructors]
**Learning:** Procedural generation inside a frequently resolved singleton constructor (like a service injected via a global View Composer) can add significant instantiation overhead. By replacing dynamic construction with static data structures, the instantiation time is essentially reduced to near zero, significantly boosting view rendering performance.
**Action:** Always favor static arrays/maps over procedural generation in service constructors when the resulting data is predictable and bounded, particularly if the service is resolved frequently during the request lifecycle.
