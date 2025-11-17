<?php

namespace Core;

use eftec\bladeone\BladeOne;

class View
{
    private static ?BladeOne $engine = null;

    protected static function engine(): BladeOne
    {
        if (!self::$engine) {
            $views = dirname(__DIR__) . '/src/views';
            $cache = dirname(__DIR__) . '/storage/cache';
            self::$engine = new BladeOne($views, $cache, BladeOne::MODE_AUTO);
        }
        return self::$engine;
    }

    public static function make(string $view, array $data = []): void
    {
        echo self::engine()->run($view, $data);
    }

    public static function share(string $key, mixed $value): void
    {
        self::engine()->share($key, $value);
    }

    public static function exists(string $view): bool
    {
        $path = dirname(__DIR__) . '/src/views/' . str_replace('.', '/', $view) . '.blade.php';
        return file_exists($path);
    }
}
