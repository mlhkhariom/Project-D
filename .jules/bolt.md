## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.
## 2026-05-24 - [ThemeService Procedural Generation Overhead]
**Learning:** `ThemeService` was dynamically computing 18 theme variations via nested loops and `array_rand()` in its constructor. Since it's a globally injected singleton, this incurred unnecessary CPU and memory overhead on *every* request, and `array_rand` made it non-deterministic (fonts varied).
**Action:** Replace procedural generation in singletons with hardcoded static arrays. This allows PHP OPcache to store the structure efficiently, achieving zero-overhead instantiation and guaranteeing determinism.
