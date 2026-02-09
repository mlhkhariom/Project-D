# Bolt's Performance Journal

## 2026-02-09 - High Frequency View Composers
**Learning:** `View::composer('*')` executes for every rendered view (layout, partials, components), amplifying unoptimized queries like `Schema::hasTable` or `DB::table` by 10x or more per page load.
**Action:** Always memoize data in services used by global view composers within the request lifecycle (static property) AND persist across requests (Cache).
