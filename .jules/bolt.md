# Bolt's Journal

## 2026-02-07 - Persistent Cache for Global Settings
**Learning:** Checking `Schema::hasTable` outside of a cache closure negates the performance benefit of caching, as it forces a DB query on every request.
**Action:** Always place schema checks or fallback logic *inside* the `Cache::remember` closure to ensure zero DB queries on cache hits.
