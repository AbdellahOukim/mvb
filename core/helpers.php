<?php

function env(string $key, $default = null)
{
    return $_ENV[$key] ?? $default;
}


function is_route($path)
{
    $current = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    return rtrim($current, '/') === rtrim($path, '/');
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

function isLang($lang)
{
    return $_SESSION['lang'] == $lang;
}

function getLang()
{
    return $_SESSION['lang'];
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


function abort(int $code = 404, string $message = "")
{
    http_response_code($code);
    $bladePath = dirname(__DIR__) . "/src/views/errors/{$code}.blade.php";
    if (file_exists($bladePath)) {
        echo \Core\View::make("errors.$code");
        exit;
    }
    $phpErrorFile = __DIR__ . "/errors/{$code}.php";
    if (file_exists($phpErrorFile)) {
        include $phpErrorFile;
        exit;
    }
    echo $message ?: "Error $code";
    exit;
}


function redirect(string $url, int $status = 302)
{
    http_response_code($status);
    header("Location: $url");
    exit;
}



function format_table($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

function format_number($number, $decimal = 2)
{
    if ($number == "") return 0;
    return number_format($number, $decimal, ',', ' ');
}

function format_date($date, $format = 'd/m/Y')
{
    if (!$date) return null;
    $timestamp = strtotime($date);
    return date($format, $timestamp);
}


function  json(array $data, int $status = 200)
{
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}
