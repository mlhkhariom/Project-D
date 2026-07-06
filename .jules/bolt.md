## 2026-02-26 - [Global View Composer Performance Trap]
**Learning:** Services injected via `View::composer('*')` execute for *every* partial view rendered (including components and includes). Without memoization, this causes severe N+1 query issues (e.g., 12 queries instead of 2 for a simple page). `Schema::hasTable` in SQLite queries `sqlite_master` and is not automatically cached by Laravel.
**Action:** Always audit global view composers for database calls and ensure strict memoization (property caching) in the service layer. Use `DB::enableQueryLog()` in feature tests to assert query counts.

## 2023-10-24 - [Zero-Overhead Service Instantiation]
**Learning:** Procedural generation of static data (like theme configurations) in the constructor of a globally injected singleton (e.g., via `View::composer('*')`) causes unnecessary execution overhead. Even if only run once per request on the first view render, looping and array manipulation consume CPU time compared to loading static memory.
**Action:** Replace procedurally generated deterministic configurations with hardcoded static arrays where possible. PHP's OPcache can store large static arrays in shared memory, allowing for zero-overhead instantiation of such services.
