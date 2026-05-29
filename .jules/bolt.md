## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-05-29 - [Procedural Generation in Globally Injected Singletons]
**Learning:** Procedurally generating deterministic data (e.g., looping to generate arrays) in the constructor of a globally injected singleton (e.g., via `View::composer('*')`) causes unnecessary execution overhead. Furthermore, using non-deterministic functions like `array_rand()` during this generation leads to hidden bugs, such as UI elements randomly changing across page loads.
**Action:** Always use hardcoded static arrays for deterministic data to ensure zero-overhead instantiation and deterministic behavior, especially in services that are frequently resolved or injected globally.
