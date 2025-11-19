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

            if (!is_dir($cache)) {
                mkdir($cache, 0777, true);
            }

            $blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);
            $blade->directive('lang', function ($expression) {
                return "<?php echo __t($expression); ?>";
            });
            $blade->directive('has_message', function ($expression) {
                return "<?php if(isset(\$_SESSION['messages'][$expression])): " .
                    "\$message = \$_SESSION['messages'][$expression]; ?>";
            });

            $blade->directive('end_has_message', function () {
                return "<?php unset(\$_SESSION['messages']); endif; ?>";
            });


            self::$engine = $blade;
        }
        return self::$engine;
    }


    public static function make(string $view, array $data = []): void
    {
        if (self::exists($view))
            echo self::engine()->run($view, $data);
        else
            abort(404, " View $view not found ");
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
