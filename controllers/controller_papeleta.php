<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../models/database.php';
require_once __DIR__ . '/../models/papeleta.php';

$base_path = '/expo_v2';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger datos del formulario
    $data = [
        'cliente_id'     => $_POST['cliente_id'],
        'folio_papeleta' => $_POST['folio_papeleta'],
        'metales'        => $_POST['metales'],
        'quien_atendio'  => $_POST['quien_atendio']
    ];

    // Crear instancia de la base de datos y del modelo Papeleta
    $db = new Database();
    $papeleta = new Papeleta($db->getConnection());
// En controller_papeleta.php
if (isset($_GET['action']) && $_GET['action'] === 'obtenerPapeletasAsignadas') {
    require_once __DIR__ . '/../models/database.php';
    // Asumiendo que tienes el modelo Papeleta o usas la conexión directa
    $db = new Database();
    $conn = $db->getConnection();

    // Obtener los id_cliente de la tabla papeletas (sin modificar clientes)
    $stmt = $conn->prepare("SELECT DISTINCT id_cliente FROM papeletas");
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $ids = [];
    foreach ($resultados as $fila) {
        $ids[] = $fila['id_cliente'];
    }

    header('Content-Type: application/json');
    echo json_encode(['data' => $ids]);
    exit();
}

    try {
        if ($papeleta->addPapeleta($data)) {
            $_SESSION['mensaje'] = 'Papeleta registrada correctamente.';
            header('Location: ' . $base_path . '/vendedor/view_vendedor?id=' . $data['cliente_id']);
            exit();
        } else {
            $_SESSION['error'] = 'Error al registrar la papeleta.';
            header('Location: ' . $base_path . '/vendedor/add_papeleta?id=' . $data['cliente_id']);
            exit();
        }
    } catch (PDOException $e) {
        // Manejo de error por duplicidad o por otro error en la inserción
        if ($e->getCode() == 23000) {
            $_SESSION['error'] = 'Error: El folio de la papeleta ya existe.';
        } else {
            $_SESSION['error'] = 'Error al registrar la papeleta: ' . $e->getMessage();
        }
        header('Location: ' . $base_path . '/vendedor/add_papeleta?id=' . $data['cliente_id']);
        exit();
    }
} else {
    header('Location: ' . $base_path);
    exit();
}
