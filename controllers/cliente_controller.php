<?php
require_once __DIR__ . '/../models/database.php';
require_once __DIR__ . '/../models/cliente.php';

$db = new Database();
$cliente = new Cliente($db->getConnection());

// Registrar Cliente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['action'])) {
    $datosCliente = [
        ':no_cliente' => $_POST['no_cliente'],
        ':nom_completo' => $_POST['nom_completo'],
        ':telefono' => $_POST['telefono'],
        ':calle' => $_POST['calle'],
        ':estado' => $_POST['estado'],
        ':ciudad' => $_POST['ciudad'],
        ':municipio' => $_POST['municipio'],
        ':pais' => $_POST['pais'],
        ':colonia' => $_POST['colonia'],
        ':no_ext' => $_POST['no_ext'],
        ':no_int' => $_POST['no_int'],
        ':requiere_factura' => isset($_POST['requiere_factura']) ? 1 : 0
    ];

    try {
        // Guardar cliente
        $cliente_id = $cliente->crear($datosCliente);
    
        if ($cliente_id && isset($_POST['requiere_factura'])) {
            // Registrar Facturación
            $datosFacturacion = [
                ':cliente_id' => $cliente_id,
                ':razon_social' => $_POST['razon_social'],
                ':rfc' => $_POST['rfc'],
                ':regimen_fiscal' => $_POST['regimen_fiscal'],
                ':uso_cfdi' => $_POST['uso_cfdi'],
                ':codigo_postal' => $_POST['codigo_postal'],
                ':correo' => $_POST['correo'],
                ':es_cliente_nuevo' => isset($_POST['es_cliente_nuevo']) ? 1 : 0,
                ':como_nos_conocio' => $_POST['como_nos_conocio']
            ];
            $cliente->registrarFacturacion($datosFacturacion);
        }
        $_SESSION['mensaje'] = 'Cliente registrado correctamente.';
        
        // Redirigir a admin (ya que solo el admin puede registrar clientes)
        $base_path = '/expo_v2';
        header('Location: ' . $base_path . '/admin');
        exit();
    } catch (PDOException $e) {
        // Manejo de error por duplicidad de clave
        if ($e->getCode() == 23000) {
            $_SESSION['error'] = 'Error: El número de cliente ya existe.';
        } else {
            $_SESSION['error'] = 'Error al registrar el cliente: ' . $e->getMessage();
        }
        // Redirigir a la misma ruta de admin para mostrar el mensaje de error
        $base_path = '/expo_v2';
        header('Location: ' . $base_path . '/admin');
        exit();
    }
    
}

// Actualizar Cliente (Edición)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'actualizar') {
    $datosCliente = [
        ':no_cliente' => $_POST['no_cliente'],
        ':nom_completo' => $_POST['nom_completo'],
        ':telefono' => $_POST['telefono'],
        ':calle' => $_POST['calle'],
        ':estado' => $_POST['estado'],
        ':ciudad' => $_POST['ciudad'],
        ':municipio' => $_POST['municipio'],
        ':pais' => $_POST['pais'],
        ':colonia' => $_POST['colonia'],
        ':no_ext' => $_POST['no_ext'],
        ':no_int' => $_POST['no_int'],
        ':requiere_factura' => isset($_POST['requiere_factura']) ? 1 : 0,
        ':id' => $_POST['id']
    ];

    $resultado = $cliente->actualizar($datosCliente);

    if ($resultado) {
        // Si se requiere factura, se debe actualizar o registrar la facturación
        if (isset($_POST['requiere_factura'])) {
            if ($cliente->existeFacturacion($_POST['id'])) {
                // Actualizar facturación existente
                $datosFacturacion = [
                    ':cliente_id' => $_POST['id'],
                    ':razon_social' => $_POST['razon_social'],
                    ':rfc' => $_POST['rfc'],
                    ':regimen_fiscal' => $_POST['regimen_fiscal'],
                    ':uso_cfdi' => $_POST['uso_cfdi'],
                    ':codigo_postal' => $_POST['codigo_postal'],
                    ':correo' => $_POST['correo'],
                    ':es_cliente_nuevo' => isset($_POST['es_cliente_nuevo']) ? 1 : 0,
                    ':como_nos_conocio' => $_POST['como_nos_conocio']
                ];
                $cliente->actualizarFacturacion($datosFacturacion);
            } else {
                // Registrar facturación si no existe previamente
                $datosFacturacion = [
                    ':cliente_id' => $_POST['id'],
                    ':razon_social' => $_POST['razon_social'],
                    ':rfc' => $_POST['rfc'],
                    ':regimen_fiscal' => $_POST['regimen_fiscal'],
                    ':uso_cfdi' => $_POST['uso_cfdi'],
                    ':codigo_postal' => $_POST['codigo_postal'],
                    ':correo' => $_POST['correo'],
                    ':es_cliente_nuevo' => isset($_POST['es_cliente_nuevo']) ? 1 : 0,
                    ':como_nos_conocio' => $_POST['como_nos_conocio']
                ];
                $cliente->registrarFacturacion($datosFacturacion);
            }
        }
        $_SESSION['mensaje'] = 'Cliente actualizado correctamente.';
        header('Location: ../views/admin/view_cliente.php');
        exit();
    } else {
        $_SESSION['mensaje'] = 'Error al actualizar el cliente.';
        header('Location: ../views/admin/edit_cliente.php?id=' . $_POST['id']);
        exit();
    }
}

// Cargar vista de edición de Cliente
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] == 'editar' && isset($_GET['id'])) {
    // Obtén los datos del cliente
    $clienteData = $cliente->obtenerPorId($_GET['id']);
    $facturacionData = $cliente->obtenerFacturacion($_GET['id']);
    
    // Renombra las variables para evitar conflictos
    $cliente = $clienteData;
    $facturacion = $facturacionData;
    
    include '../views/admin/edit_cliente.php';
    exit();
}


// Obtener Clientes (para la tabla)
if (isset($_GET['action']) && $_GET['action'] == 'obtenerClientes') {
    $clientes = $cliente->obtenerClientes();
    
    // Verifica si hay datos
    if ($clientes) {
        // Devuelve los datos en formato JSON
        header('Content-Type: application/json');
        echo json_encode(['data' => $clientes]);
    } else {
        // Devuelve un JSON vacío si no hay datos
        header('Content-Type: application/json');
        echo json_encode(['data' => []]);
    }
    exit();
}
?>
