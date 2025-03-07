<?php
// Iniciar la sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$base_path = '/expo_v2';

// Obtener la ruta solicitada
$request = $_SERVER['REQUEST_URI'];
$request = str_replace($base_path, '', $request); // Eliminar la ruta base
$request = explode('?', $request)[0]; // Eliminar parámetros de la URL

// Definir las rutas del sistema
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
    '/clientes/edit' => 'views/clientes/edit_cliente.php', // Ruta para editar cliente
    '/clientes/view' => 'views/clientes/view_cliente.php',
    '/clientes/controller' => 'controllers/cliente_controller.php',
    '/clientes/view_factura' => 'views/clientes/view_factura.php',
    '/clientes/view_envio' => 'views/clientes/view_envio.php',
];

// Cargar modelos y controladores
require_once __DIR__ . '/models/database.php';
require_once __DIR__ . '/models/cliente.php';

// Crear instancia de la base de datos y del modelo Cliente
$db = new Database();
$cliente = new Cliente($db->getConnection());

// Manejo de rutas
if (array_key_exists($request, $routes)) {
    // Verificar si la ruta es protegida
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

    // Manejo de la ruta de edición de cliente
    if ($request == '/clientes/edit' && isset($_GET['id'])) {
        $clienteData = $cliente->obtenerPorId($_GET['id']);
        $facturacionData = $cliente->obtenerFacturacion($_GET['id']);
        
        if ($clienteData) {
            // Pasar los datos a la vista
            $cliente = $clienteData;
            $facturacion = $facturacionData;
            require __DIR__ . '/views/clientes/edit_cliente.php';
        } else {
            // Si no se encuentra el cliente, redirigir a una página de error
            header('Location: ' . $base_path . '/404');
            exit();
        }
    } else {
        // Cargar la vista correspondiente
        require __DIR__ . '/' . $routes[$request];
    }
} else {
    http_response_code(404);
    require __DIR__ . '/views/404.php';
}
?>