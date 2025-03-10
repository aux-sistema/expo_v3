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

    try {
        if ($papeleta->addPapeleta($data)) {
            // Recuperar el id de la papeleta recién insertada
            $idPapeleta = $db->getConnection()->lastInsertId();
            $_SESSION['mensaje'] = 'Papeleta registrada correctamente.';
            // Redirigir según el tipo de entrega seleccionado
            if (isset($_POST['tipo_entrega']) && $_POST['tipo_entrega'] == 'recoleccion') {
                header('Location: ' . $base_path . '/vendedor/recoleccion.php?id_papeleta=' . $idPapeleta . '&cliente_id=' . $_POST['cliente_id']);
                exit();
            } elseif (isset($_POST['tipo_entrega']) && $_POST['tipo_entrega'] == 'envio') {
                header('Location: ' . $base_path . '/vendedor/envio.php?id_papeleta=' . $idPapeleta . '&cliente_id=' . $_POST['cliente_id']);
                exit();
            } else {
                header('Location: ' . $base_path . '/vendedor/view_vendedor?id=' . $_POST['cliente_id']);
                exit();
            }
        } else {
            $_SESSION['error'] = 'Error al registrar la papeleta.';
            header('Location: ' . $base_path . '/vendedor/add_papeleta.php?id=' . $_POST['cliente_id']);
            exit();
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $_SESSION['error'] = 'Error: El folio de la papeleta ya existe.';
        } else {
            $_SESSION['error'] = 'Error al registrar la papeleta: ' . $e->getMessage();
        }
        header('Location: ' . $base_path . '/vendedor/add_papeleta.php?id=' . $_POST['cliente_id']);
        exit();
    }
} else {
    header('Location: ' . $base_path);
    exit();
}
?>
