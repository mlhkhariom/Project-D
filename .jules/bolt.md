## 2026-02-12 - ThemeService Memoization
**Learning:** Services injected via `View::composer('*')` run on every partial render. Database queries within these services must be memoized to prevent N+1 issues. In this project, `ThemeService` caused duplicate `settings` table lookups.
**Action:** Always verify memoization in global view composers. Use protected properties to cache results within the request lifecycle.
