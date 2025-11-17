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
