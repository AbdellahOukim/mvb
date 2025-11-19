<?php

function env(string $key, $default = null)
{
    return $_ENV[$key] ?? $default;
}


function __t(string $key, array $replace = []): string
{
    static $translations = [];
    static $locale = null;

    if (!$locale) {
        $locale = $_SESSION['lang'] ?? 'fr';
    }

    if (!isset($translations[$locale])) {
        $file = dirname(__DIR__) . "/src/lang/$locale.php";
        $translations[$locale] = file_exists($file) ? include $file : [];
    }

    $text = $translations[$locale][$key] ?? $key;

    foreach ($replace as $k => $v) {
        $text = str_replace(":$k", $v, $text);
    }

    return $text;
}

function setLang(string $locale)
{
    $_SESSION['lang'] = $locale;
}


function old(string $key, $default = null)
{
    if (isset($_SESSION['old'][$key])) {
        $value = $_SESSION['old'][$key];
        unset($_SESSION['old'][$key]);
        return $value;
    }
    return $default;
}


function can(string $policy, string $method, $resource = []): bool
{
    return \Core\Policy::check($policy, $method, $resource);
}


function abort(int $code = 404, $message = "")
{
    http_response_code($code);

    $errorFile = __DIR__ . "/errors/{$code}.php";

    if (file_exists($errorFile)) {
        include $errorFile;
    } else {
        echo $message ?? "Error $code";
    }

    exit;
}
