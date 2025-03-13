<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../models/database.php';
require_once __DIR__ . '/../models/papeleta.php';
require_once __DIR__ . '/../models/mesa.php';

$base_path = '/expo_v2';

$db = new Database();
$pdo = $db->getConnection();
$papeletaModel = new Papeleta($pdo);

// Se espera que la asignación se realice mediante POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idPapeleta = $_POST['id_papeleta'] ?? null;
    $idMesa     = $_POST['id_mesa'] ?? null;
    
    if (!$idPapeleta || !$idMesa) {
        $_SESSION['error'] = "Faltan datos para asignar la mesa.";
        header("Location: {$base_path}/vendedor/papeleta/mesa");
        exit();
    }
    
    // Obtener la información de la mesa para conocer su capacidad
    require_once __DIR__ . '/../models/mesa.php';
    $mesaModel = new Mesa($pdo);
    $mesa = $mesaModel->getById($idMesa);
    if (!$mesa) {
        $_SESSION['error'] = "Mesa no encontrada.";
        header("Location: {$base_path}/vendedor/papeleta/mesa");
        exit();
    }
    
    // Contar cuántas papeletas ya tienen asignada esa mesa
    $currentCount = $papeletaModel->countAsignacionesMesa($idMesa);
    if ($currentCount >= $mesa['capacidad']) {
        $_SESSION['error'] = "La mesa ha alcanzado el límite máximo de cupos.";
        header("Location: {$base_path}/vendedor/papeleta/asignar_mesas?id=" . $idPapeleta);
        exit();
    }
    
    // Si hay cupo disponible, procede a asignar la mesa
    $result = $papeletaModel->updateMesa($idPapeleta, $idMesa);
    
    if ($result) {
        $_SESSION['mensaje'] = "Mesa asignada correctamente.";
    } else {
        $_SESSION['error'] = "Error al asignar la mesa.";
    }
    
    header("Location: {$base_path}/vendedor/papeleta/asignar_mesas?id=" . $idPapeleta);
    exit();
} else {
    // Si se accede por GET, redirige al listado
    header("Location: {$base_path}/vendedor/papeleta/asignar_mesas?id=" . $idPapeleta);    exit();
}
?>
