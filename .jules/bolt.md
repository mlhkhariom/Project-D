## 2026-02-13 - View Composer N+1 with SQLite Schema Checks
**Learning:** `View::composer('*')` triggers for every single view partial. When combined with `Schema::hasTable` (which logs as a SELECT query in SQLite) inside a service getter that isn't memoized, it causes thousands of queries per request (e.g., 1200+ for the welcome page).
**Action:** Always verify memoization in services injected into global view composers.
