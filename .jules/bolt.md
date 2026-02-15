## 2026-02-15 - N+1 Schema Checks in View Composer
**Learning:** `Schema::hasTable` triggers a database query on every execution. When used in a service method injected via a global View Composer (`View::composer('*')`), it runs for every partial/component, causing significant N+1 issues even if the data query is simple.
**Action:** Memoize the result of schema checks or configuration lookups in singleton services to avoid repeated database hits during a single request.
