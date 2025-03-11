<?php
// Iniciar la sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$base_path = '/expo_v2';
require_once __DIR__ . '/models/database.php';
require_once __DIR__ . '/models/cliente.php';

// Crear instancia de la base de datos y del modelo Cliente
$db = new Database();
$cliente = new Cliente($db->getConnection());

// Obtener la ruta solicitada
$request = $_SERVER['REQUEST_URI'];
$request = str_replace($base_path, '', $request); 
$request = explode('?', $request)[0]; 

$routes = [
    '/login' => 'views/auth/login.php',
    '/registro' => 'views/auth/registro.php',
    '/auth/password/recover' => 'views/auth/password/recover.php',
    '/auth/password/reset_password' => 'views/auth/password/reset_password.php',
    '/auth/password/reset' => 'views/auth/password/reset.php',
    '/auth/password/update_password' => 'views/auth/password/update_password.php',
    '/auth/check_session' => 'views/auth/check_session.php',
    '/auth/logout' => 'views/auth/logout.php',
    '/404' => 'views/404.php',
    '/403' => 'views/403.php',

    '/admin' => 'views/admin/add_cliente.php',
    '/admin/edit' => 'views/admin/edit_cliente.php',
    '/admin/view' => 'views/admin/view_cliente.php',
    '/admin/controller' => 'controllers/cliente_controller.php',
    '/admin/view_factura' => 'views/admin/view_factura.php',
    '/admin/view_envio' => 'views/admin/view_envio.php',

    '/vendedor/controller_envio' => 'controllers/envio.php',
    '/vendedor/controller' => 'controllers/controller_papeleta.php',
    '/vendedor' => 'views/vendedor/view_vendedor.php',
    '/vendedor/edit' => 'views/vendedor/edit_cliente.php',
    '/vendedor/edit_envio' => 'views/vendedor/edit_cliente_envio.php',
    '/vendedor/view_vendedor' => 'views/vendedor/view_vendedor.php',
    '/vendedor/papeleta/tipo_entrega' => 'views/vendedor/menu_tipo_entrega.php',
    '/vendedor/add_papeleta' => 'views/vendedor/add_papeleta.php',
    '/vendedor/recoleccion' => 'views/vendedor/recoleccion.php',
    '/vendedor/envio' => 'views/vendedor/envios.php',

    '/cliente' => 'views/cliente.php',
];

function checkAuth($request)
{
    global $base_path;

    $public_routes = [
        '/login',
        '/registro',
        '/auth/password/recover',
        '/auth/password/reset_password',
        '/auth/password/reset',
        '/admin/edit',
        '/auth/password/update_password',
        '/admin/controller',
        '/vendedor/controller'
    ];

    if (in_array($request, $public_routes)) {
        return true;
    }

    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header('Location: ' . $base_path . '/login');
        exit();
    }

    $admin_routes = [
        '/admin',

        '/admin/view',

        '/admin/view_factura',
        '/admin/view_envio',
    ];

    $vendedor_routes = [
        '/vendedor',
        '/vendedor/add_papeleta',

    ];

    $cliente_routes = [
        '/cliente',
    ];

    if (in_array($request, $admin_routes)) {
        if ($_SESSION['id_cargo'] !== 1) { 
            header('Location: ' . $base_path . '/403'); 
            exit();
        }
    }

    if (in_array($request, $vendedor_routes)) {
        if ($_SESSION['id_cargo'] !== 2) { 
            header('Location: ' . $base_path . '/403');
            exit();
        }
    }

    if (in_array($request, $cliente_routes)) {
        if ($_SESSION['id_cargo'] !== 3) { 
            header('Location: ' . $base_path . '/403'); 
            exit();
        }
    }

    return true; // Permitir acceso
}

// Manejo de rutas
if (array_key_exists($request, $routes)) {
    // Verificar autenticación y autorización
    checkAuth($request);

    if ($request == '/vendedor' && isset($_GET['id'])) {
        $clienteData = $cliente->obtenerPorId($_GET['id']);
        $facturacionData = $cliente->obtenerFacturacion($_GET['id']);

        if ($clienteData) {
            $cliente = $clienteData;
            $facturacion = $facturacionData;
            define('PROTECTED_ACCESS', true); // Evitar acceso directo a archivos
            require __DIR__ . '/views/vendedor/view_vendedor.php';
            exit(); // Detener la ejecución después de cargar la vista
        } else {
            header('Location: ' . $base_path . '/404');
            exit();
        }
    }
    if ($request == '/vendedor/add_papeleta' && isset($_GET['id'])) {
        $clienteData = $cliente->obtenerPorId($_GET['id']);

        if ($clienteData) {
            $cliente = $clienteData;
            define('PROTECTED_ACCESS', true); // Evitar acceso directo a archivos
            require __DIR__ . '/views/vendedor/add_papeleta.php';
            exit(); // Detener la ejecución después de cargar la vista
        } else {
            header('Location: ' . $base_path . '/404');
            exit();
        }
    }

    // Manejo de rutas específicas
    if ($request == '/admin/view_factura' && isset($_GET['id'])) {
        $clienteData = $cliente->obtenerPorId($_GET['id']);
        $facturacionData = $cliente->obtenerFacturacion($_GET['id']);

        if ($clienteData) {
            $cliente = $clienteData;
            $facturacion = $facturacionData;
            define('PROTECTED_ACCESS', true); // Evitar acceso directo a archivos
            require __DIR__ . '/views/admin/view_factura.php';
            exit(); // Detener la ejecución después de cargar la vista
        } else {
            header('Location: ' . $base_path . '/404');
            exit();
        }
    }

    if ($request == '/admin/view_envio' && isset($_GET['id'])) {
        $clienteData = $cliente->obtenerPorId($_GET['id']);
        $facturacionData = $cliente->obtenerFacturacion($_GET['id']);

        if ($clienteData) {
            $cliente = $clienteData;
            $facturacion = $facturacionData;
            define('PROTECTED_ACCESS', true); // Evitar acceso directo a archivos
            require __DIR__ . '/views/admin/view_envio.php';
            exit(); // Detener la ejecución después de cargar la vista
        } else {
            header('Location: ' . $base_path . '/404');
            exit();
        }
    }

    if ($request == '/admin/edit' && isset($_GET['id'])) {
        $clienteData = $cliente->obtenerPorId($_GET['id']);
        $facturacionData = $cliente->obtenerFacturacion($_GET['id']);

        if ($clienteData) {
            $cliente = $clienteData;
            $facturacion = $facturacionData;
            define('PROTECTED_ACCESS', true); // Evitar acceso directo a archivos
            require __DIR__ . '/views/admin/edit_cliente.php';
            exit(); // Detener la ejecución después de cargar la vista
        } else {
            header('Location: ' . $base_path . '/404');
            exit();
        }
    }

    if ($request == '/vendedor/edit' && isset($_GET['id'])) {
        $clienteData = $cliente->obtenerPorId($_GET['id']);
        $facturacionData = $cliente->obtenerFacturacion($_GET['id']);

        if ($clienteData) {
            $cliente = $clienteData;
            $facturacion = $facturacionData;
            define('PROTECTED_ACCESS', true); // Evitar acceso directo a archivos
            require __DIR__ . '/views/vendedor/edit_cliente.php';
            exit(); // Detener la ejecución después de cargar la vista
        } else {
            header('Location: ' . $base_path . '/404');
            exit();
        }
    }

    if ($request == '/vendedor/edit_envio' && isset($_GET['id'])) {
        $clienteData = $cliente->obtenerPorId($_GET['id']);
        $facturacionData = $cliente->obtenerFacturacion($_GET['id']);

        if ($clienteData) {
            $cliente = $clienteData;
            $facturacion = $facturacionData;
            define('PROTECTED_ACCESS', true); // Evitar acceso directo a archivos
            require __DIR__ . '/views/vendedor/edit_cliente_envio.php';
            exit(); // Detener la ejecución después de cargar la vista
        } else {
            header('Location: ' . $base_path . '/404');
            exit();
        }
    }

    // Cargar la vista correspondiente
    define('PROTECTED_ACCESS', true); // Evitar acceso directo a archivos
    require __DIR__ . '/' . $routes[$request];
} else {
    // Ruta no encontrada
    http_response_code(404);
    require __DIR__ . '/views/404.php';
}
?>