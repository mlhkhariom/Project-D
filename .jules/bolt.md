## 2026-02-08 - ThemeService N+1 Optimization
**Learning:** `View::composer('*')` is a dangerous pattern when combined with unoptimized service calls. A single DB query in a service used by a global view composer can multiply into dozens of queries per page load.
**Action:** Always implement request-level memoization (static/instance variable) in services that are called frequently, especially those used in view composers.
