# Bolt's Journal

## 2026-02-20 - ThemeService N+1 Bottleneck
**Learning:** `ThemeService` was calling `Schema::hasTable` and executing DB queries on every invocation. Since it's injected via `View::composer('*')`, this caused redundant queries for every view partial, leading to 12+ queries on a simple page load instead of 2.
**Action:** Always check how services are injected. If injected into `*` views, memoization in the service is critical. Also, `Schema::hasTable` in SQLite is not free (it's a query).
