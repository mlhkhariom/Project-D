1. **Replace procedural theme generation with hardcoded array in `ThemeService`**:
   - The `ThemeService` constructor currently calls `generateProceduralThemes()`, which uses loops and `array_rand()` to procedurally generate themes. This introduces overhead during instantiation, which happens on the first view render due to it being injected globally via `View::composer('*')`.
   - I will replace this logic with a fully hardcoded, static array of 20 themes.
   - This eliminates the runtime computation overhead and makes font selection deterministic.
2. **Remove the `generateProceduralThemes` method and `__construct`**:
   - Since the themes will be statically defined, the constructor and procedural generation method are no longer needed.
3. **Run tests**:
   - Run `php artisan test` to ensure all tests, including `ThemePerformanceTest`, still pass.
4. **Complete pre-commit steps**:
   - Ensure proper testing, verification, review, and reflection are done by calling `pre_commit_instructions`.
5. **Submit PR**:
   - Create a PR with the title '⚡ Bolt: [performance improvement]' and include 'What', 'Why', 'Impact', and 'Measurement' sections in the description, as per Bolt's guidelines.
