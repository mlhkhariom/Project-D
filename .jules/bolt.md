## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-02-26 - [Procedural Generation in Globally Injected Services]
**Learning:** Services injected globally (e.g., via `View::composer('*')`) instantiate for the first view render of every request. Using procedural generation (loops, `array_rand()`) inside their constructor causes significant runtime CPU overhead and introduces non-deterministic behavior (like random font changes across page loads).
**Action:** Replace procedural configuration generation with static, hardcoded arrays in singletons. This allows PHP OPcache to optimize the array and eliminates the overhead completely.
