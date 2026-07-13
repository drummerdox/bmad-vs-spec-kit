<?php

namespace App\Support;

final class Theme
{
    public const COOKIE = 'todolist_theme';

    public const LIGHT = 'light';

    public const DARK = 'dark';

    public static function resolve(?string $value): string
    {
        return in_array($value, [self::LIGHT, self::DARK], true) ? $value : self::LIGHT;
    }

    public static function isDark(?string $value): bool
    {
        return self::resolve($value) === self::DARK;
    }
}
