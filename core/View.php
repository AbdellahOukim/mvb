<?php

namespace Core;

class View
{
    private static array $sections = [];
    private static ?string $extends = null;

    public static function make(string $view, array $data = [])
    {
        self::$sections = [];
        self::$extends = null;

        $content = self::getViewContent($view);
        $content = self::compileIncludes($content);
        $content = self::compileExtendsAndSections($content);

        extract($data);

        if (self::$extends) {
            $layout = self::getViewContent(self::$extends);
            $layout = self::compileIncludes($layout);
            $layout = self::injectSections($layout);
            eval('?>' . $layout);
        } else {
            eval('?>' . $content);
        }
    }

    private static function getViewContent(string $view): string
    {
        $file = __DIR__ . '/../src/views/' . str_replace('.', '/', $view) . '.php';
        if (!file_exists($file)) {
            $error = $view . ".php Not found ! ";
            include_once('errors/error.php');
            exit;
        }
        return file_get_contents($file);
    }

    private static function compileIncludes(string $content): string
    {
        return preg_replace_callback(
            '/#include\(\'(.+?)\'\)/',
            fn($m) => self::getViewContent($m[1]) ?? '',
            $content
        );
    }

    private static function compileExtendsAndSections(string $content): string
    {
        if (preg_match('/#use\(\'(.+?)\'\)/', $content, $m)) {
            self::$extends = $m[1];
            $content = str_replace($m[0], '', $content);
        }

        return preg_replace_callback(
            '/#section\(\'(.+?)\'\)(.*?)#endsection/s',
            function ($m) {
                self::$sections[$m[1]] = $m[2];
                return '';
            },
            $content
        );
    }



    private static function injectSections(string $layout): string
    {
        return preg_replace_callback(
            '/#make\(\'(.+?)\'\)/',
            fn($m) => self::$sections[$m[1]] ?? '',
            $layout
        );
    }
}
