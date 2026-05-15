<?php
// ============================================
// UMUGANDA MVC - Front Controller
// ============================================

session_start();

// Error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define base path constants (only if not already defined)
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}
if (!defined('CONTROLLER_PATH')) {
    define('CONTROLLER_PATH', BASE_PATH . '/app/controllers/');
}
if (!defined('MODEL_PATH')) {
    define('MODEL_PATH', BASE_PATH . '/app/models/');
}
if (!defined('VIEW_PATH')) {
    define('VIEW_PATH', BASE_PATH . '/app/views/');
}
if (!defined('CONFIG_PATH')) {
    define('CONFIG_PATH', BASE_PATH . '/config/');
}

// Autoloader function
spl_autoload_register(function ($class) {
    // Check controllers
    $controller_file = CONTROLLER_PATH . $class . '.php';
    if (file_exists($controller_file)) {
        require_once $controller_file;
        return;
    }
    
    // Check models
    $model_file = MODEL_PATH . $class . '.php';
    if (file_exists($model_file)) {
        require_once $model_file;
        return;
    }
});

// Load routes
if (file_exists(CONFIG_PATH . 'routes.php')) {
    $routes = require_once CONFIG_PATH . 'routes.php';
} else {
    die('Error: routes.php file not found in ' . CONFIG_PATH);
}

// Get request method and URI
$method = $_SERVER['REQUEST_METHOD'];
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove base path from URI
$base_path = '/umuganda-mvc';
if (strpos($request_uri, $base_path) === 0) {
    $uri = substr($request_uri, strlen($base_path));
}
if (empty($uri)) $uri = '/';

// Route matching
$route_found = false;
$params = [];

foreach ($routes[$method] as $route => $handler) {
    // Convert route pattern to regex for dynamic segments
    $pattern = '#^' . preg_replace('/\{[a-z]+\}/', '([^/]+)', $route) . '$#';
    
    if (preg_match($pattern, $uri, $matches)) {
        array_shift($matches);
        $params = $matches;
        $controller_name = $handler[0];
        $action = $handler[1];
        $route_found = true;
        break;
    }
}

if ($route_found) {
    if (class_exists($controller_name)) {
        $controller = new $controller_name();
        if (method_exists($controller, $action)) {
            call_user_func_array([$controller, $action], $params);
        } else {
            http_response_code(500);
            echo "Error: Method '$action' not found in controller '$controller_name'";
        }
    } else {
        http_response_code(500);
        echo "Error: Controller '$controller_name' not found";
    }
} else {
    // If no route found, try to serve as API or show 404
    if (strpos($uri, '/api/') === 0) {
        header('Content-Type: application/json');
        echo json_encode(["success" => false, "message" => "API endpoint not found: " . $uri]);
    } else {
        http_response_code(404);
        echo "404 - Page not found: " . $uri;
    }
}
?>