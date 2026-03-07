## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2026-03-05 - [Deferring Expensive Service Constructors]
**Learning:** Constructors of services injected via global View Composers (e.g. `View::composer('*')`) will execute whenever the first view is rendered. If these constructors perform expensive operations like procedural generation or heavy computation, it introduces unnecessary overhead on *every* request that renders a view, even if the computed data isn't used by the active theme.
**Action:** Always lazy-load (defer) expensive computations in services. Do not put heavy initialization logic in the `__construct()` method; instead, use a getter that generates the data only when it's specifically accessed.
