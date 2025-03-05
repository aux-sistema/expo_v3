<?php
require_once '../models/database.php';
require_once '../models/cliente.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $cliente = new Cliente($db->getConnection());

    $datosCliente = [
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

    if ($cliente->crear($datosCliente)) {
        $_SESSION['mensaje'] = 'Cliente registrado correctamente.';
    } else {
        $_SESSION['error'] = 'Error al registrar el cliente.';
    }

    header('Location: ../views/clientes/add_cliente.php');
    exit();
}
?>