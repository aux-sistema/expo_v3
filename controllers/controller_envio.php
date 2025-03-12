<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../models/database.php';
$base_path = '/expo_v2';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_papeleta = $_POST['id_papeleta'];
    $cliente_id = $_POST['cliente_id'];
    $direccion_envio = $_POST['direccion_envio'];

    $db = new Database();
    $conn = $db->getConnection();
    $stmt = $conn->prepare("INSERT INTO envio (id_papeleta, direccion_envio) VALUES (?, ?)");
    if ($stmt->execute([$id_papeleta, $direccion_envio])) {
        $_SESSION['mensaje'] = 'Datos de envío guardados correctamente.';
        header("Location: $base_path/vendedor/view_vendedor?id=$cliente_id");
        exit();
    } else {
        $_SESSION['error'] = 'Error al guardar los datos de envío.';
        header("Location: $base_path/vendedor/envios.php?id_papeleta=$id_papeleta&cliente_id=$cliente_id");
        exit();
    }
} else {
    header("Location: $base_path");
    exit();
}
?>
