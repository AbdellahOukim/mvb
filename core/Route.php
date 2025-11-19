<?php

namespace Core;

class Route
{
    private static array $routes = [];
    private static array $currentMiddlewares = [];

    public static function make(string $base, string $controller)
    {
        self::$routes[$base] = [
            'controller' => $controller,
            'middlewares' => self::$currentMiddlewares
        ];
        uksort(self::$routes, function ($a, $b) {
            if ($a === '/') return 1;
            if ($b === '/') return -1;
            return strlen($b) - strlen($a);
        });
    }


    public static function middleware(array|string $middlewares, callable $callback)
    {
        $middlewares = is_array($middlewares) ? $middlewares : [$middlewares];

        $previous = self::$currentMiddlewares;
        self::$currentMiddlewares = $middlewares;

        $callback();

        self::$currentMiddlewares = $previous;
    }

    public static function dispatch()
    {
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
        $uri = rtrim($uri, '/') ?: '/';

        foreach (self::$routes as $base => $route) {
            if (str_starts_with($uri, $base)) {

                if (!empty($route['middlewares'])) {
                    self::runMiddlewares($route['middlewares']);
                }

                $controller = $route['controller'];
                $path = trim(substr($uri, strlen($base)), '/');
                $method = $path === '' ? 'index' : explode('/', $path)[0];
                $params = $path === '' ? [] : array_slice(explode('/', $path), 1);

                if (!class_exists($controller)) {
                    http_response_code(500);
                    $message = "Controller $controller not found";
                    return abort(500, $message);
                }

                $instance = new $controller;

                if (!method_exists($instance, $method)) {
                    http_response_code(404);
                    $message = "Method $method not found in $controller";
                    return abort(404, $message);
                }

                call_user_func_array([$instance, $method], $params);
                return;
            }
        }

        http_response_code(404);
        return abort(404);
    }

    private static function runMiddlewares(array $middlewares)
    {
        foreach ($middlewares as $item) {
            [$name, $params] = self::parseMiddleware($item);

            $middlewareClass = '\\App\\middlewares\\' . ucfirst($name) . 'Middleware';

            if (!class_exists($middlewareClass)) {
                throw new \Exception("Middleware $name not found [$middlewareClass]");
            }

            $middleware = new $middlewareClass();

            if (!method_exists($middleware, 'handle')) {
                throw new \Exception("Middleware $name has no handle() method");
            }

            $middleware->handle(...$params);
        }
    }

    private static function parseMiddleware(string $middleware): array
    {
        if (str_contains($middleware, ':')) {
            [$name, $paramStr] = explode(':', $middleware, 2);
            $params = explode(',', $paramStr);
        } else {
            $name = $middleware;
            $params = [];
        }

        return [$name, $params];
    }
}
