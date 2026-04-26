<?php
if (php_sapi_name() !== 'cli') {
    session_start();
}

require_once __DIR__ . '/../app/Core/Env.php';
Env::load(__DIR__ . '/../.env');

if (php_sapi_name() !== 'cli') {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $script = dirname($_SERVER['SCRIPT_NAME']);
    $base_url = $protocol . '://' . $host . ($script === '\\' || $script === '/' ? '' : $script);
    define('BASE_URL', rtrim($base_url, '/'));
} else {
    define('BASE_URL', '');
}

$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

$controllerName = isset($url[0]) && $url[0] != '' ? ucfirst($url[0]) . 'Controller' : 'HomeController';
$methodName = isset($url[1]) && $url[1] != '' ? $url[1] : 'index';


spl_autoload_register(function ($class) {
    if (class_exists($class)) return;

    $paths = [
        __DIR__ . '/../app/Controllers/' . $class . '.php',
        __DIR__ . '/../app/Core/' . $class . '.php',
        __DIR__ . '/../app/Models/' . $class . '.php'
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

if (php_sapi_name() !== 'cli') {
    if (class_exists($controllerName)) {
        $controller = new $controllerName();
        if (method_exists($controller, $methodName)) {
            unset($url[0]);
            unset($url[1]);
            $params = $url ? array_values($url) : [];
            call_user_func_array([$controller, $methodName], $params);
        } else {
            echo "Method $methodName not found in $controllerName.";
        }
    } else {
        echo "Controller $controllerName not found.";
    }
}
