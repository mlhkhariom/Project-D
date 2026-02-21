## 2024-05-23 - ThemeService Memoization
**Learning:** Checking Schema::hasTable inside a service method called by View::composer('*') causes N+1 queries (specifically 'select exists' in SQLite) for every view/partial rendered.
**Action:** Always memoize service methods that are injected globally into views.
