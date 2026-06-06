<?php
$content = file_get_contents('app/Services/ThemeService.php');
$content = preg_replace(
    "/protected array \\\$themes = \\[/s",
    "/**\n     * Static mapping of all themes.\n     * Hardcoded to utilize PHP OPcache and avoid procedural generation overhead\n     * on every request, providing a zero-overhead instantiation.\n     */\n    protected array \$themes = [",
    $content
);
file_put_contents('app/Services/ThemeService.php', $content);
