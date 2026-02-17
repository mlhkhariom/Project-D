## 2026-02-05 - Hidden SQLite Query Costs
**Learning:** In SQLite environments, `Schema::hasTable` operations are not cached by the Laravel framework and generate a `select exists` query every time they are called. This can lead to massive N+1 issues (1200+ queries) in high-traffic paths like View Composers, even if the primary data fetch is optimized.
**Action:** Always memoize the result of `Schema::hasTable` checks or the resulting configuration state within service classes that are instantiated as singletons, especially when used in global view composers.
