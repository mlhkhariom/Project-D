## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2023-10-27 - [Singleton Constructor Performance Trap]
**Learning:** `ThemeService` is injected globally (`View::composer('*')`) which causes it to be instantiated on every request. Even minor computational work inside the constructor (like generating arrays procedurally or calling `array_rand`) becomes an unnecessary performance bottleneck because the service executes on every single web transaction, including basic views.
**Action:** Move static data out of PHP procedural generation into hardcoded array structures inside singletons. Avoid computing static configuration dynamically during a constructor of a heavily utilized service.
