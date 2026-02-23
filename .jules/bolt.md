## 2026-02-05 - View Composers with Database Calls
**Learning:** `View::composer('*', ...)` executes for every single partial, layout, and component. Any database call inside the composer (even a `Schema::hasTable` check) will be repeated dozens of times per page load if not memoized.
**Action:** Always memoize/cache results of services injected via wildcard view composers. Use singleton service properties or `static` variables for request-scoped caching.
