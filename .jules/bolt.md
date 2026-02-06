# BOLT'S JOURNAL - CRITICAL LEARNINGS ONLY

## 2024-05-22 - View Composer N+1
**Learning:** Using `View::composer('*')` to share data globaly can lead to severe N+1 query issues if the shared data involves DB calls. `Schema::hasTable` is also a query and should be cached or avoided in hot paths.
**Action:** Always cache data shared via `View::composer('*')` (application cache or singleton request cache).
