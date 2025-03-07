<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Evitar almacenamiento en caché
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$request = $_SERVER['REQUEST_URI'];
$base_path = '/expo_v2';
$request = str_replace($base_path, '', $request);
$request = explode('?', $request)[0];

$routes = [
    '/login' => 'views/auth/login.php',
    '/registro' => 'views/auth/registro.php',
    '/admin' => 'views/clientes/add_cliente.php',
    '/vendedor' => 'views/vendedor.php',
    '/cliente' => 'views/cliente.php',
    '/auth/password/recover' => 'views/auth/password/recover.php',
    '/auth/password/reset_password' => 'views/auth/password/reset_password.php',
    '/auth/password/reset' => 'views/auth/password/reset.php',
    '/auth/password/update_password' => 'views/auth/password/update_password.php',
    '/auth/check_session' => 'views/auth/check_session.php',
    '/auth/logout' => 'views/auth/logout.php',
    '/404' => 'views/404.php',
    '/clientes/edit' => 'views/clientes/edit_cliente.php',
    '/clientes/view' => 'views/clientes/view_cliente.php',
    '/clientes/controller' => 'controllers/cliente_controller.php',
];

if (array_key_exists($request, $routes)) {
    $protected_routes = ['/admin', '/vendedor', '/cliente'];
    if (in_array($request, $protected_routes)) {
        if (!isset($_SESSION['loggedin'])) {
            header('Location: ' . $base_path . '/login');
            exit();
        }
        $allowed_roles = [
            '/admin' => 1,
            '/vendedor' => 2,
            '/cliente' => 3,
        ];
        if ($_SESSION['id_cargo'] !== $allowed_roles[$request]) {
            header('Location: ' . $base_path . '/404');
            exit();
        }
    }
    require __DIR__ . '/' . $routes[$request];
} else {
    http_response_code(404);
    require __DIR__ . '/views/404.php';
}
?>
