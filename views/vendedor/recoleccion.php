<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../models/database.php';
require_once __DIR__ . '/../../models/recoleccion.php';

$base_path = '/expo_v2';

$db = new Database();
$conn = $db->getConnection();

// Parámetros configurables
$maxCitasPorHora = 5; // Valor inicial, luego se puede cambiar a 7, etc.
$horarioInicio   = 10;   // Hora de inicio (10:00 AM)
$horarioFin      = 18;   // Hora de fin (6:00 PM)

// Se asume que el id del cliente se pasa por GET para redirecciones posteriores
$cliente_id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Calcular las fechas disponibles (5 días: hoy y los próximos 4 días)
    $availableDates = [];
    for ($i = 0; $i < 5; $i++) {
        $availableDates[] = date('Y-m-d', strtotime("+$i days"));
    }
    // Incluir la vista del formulario de recolección
    include __DIR__ . '/../partials/recoleccion_form.php';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger datos del formulario
    $id_papeleta = $_POST['id_papeleta'];
    $fecha       = $_POST['fecha'];
    $hora        = $_POST['hora'];

    // Validar que la fecha esté dentro del rango permitido
    $today   = date('Y-m-d');
    $maxDate = date('Y-m-d', strtotime("+4 days")); // 5 días en total (hoy + 4 días)
    if ($fecha < $today || $fecha > $maxDate) {
        $_SESSION['error'] = "La fecha seleccionada no es válida.";
        header('Location: ' . $base_path . '/vendedor/recoleccion?id=' . $cliente_id);
        exit();
    }

    // Validar que la hora esté dentro del horario permitido
    if (intval($hora) < $horarioInicio || intval($hora) > $horarioFin) {
        $_SESSION['error'] = "La hora seleccionada no está dentro del horario permitido.";
        header('Location: ' . $base_path . '/vendedor/recoleccion?id=' . $cliente_id);
        exit();
    }

    $recoleccion = new Recoleccion($conn);
    // Verificar si ya se alcanzó el cupo para esa franja
    $existingCitas = $recoleccion->getCitasPorHora($fecha, $hora);
    if ($existingCitas >= $maxCitasPorHora) {
        $_SESSION['error'] = "La franja horaria seleccionada ya tiene el cupo máximo.";
        header('Location: ' . $base_path . '/vendedor/recoleccion?id=' . $cliente_id);
        exit();
    }

    // Preparar los datos para registrar la cita
    $data = [
        'id_papeleta' => $id_papeleta,
        'fecha'       => $fecha,
        'hora'        => $hora,
        'estado'      => 'confirmada'
    ];

    try {
        if ($recoleccion->addCita($data)) {
            $_SESSION['mensaje'] = "Cita de recolección agendada correctamente para $fecha a las $hora:00.";
            header('Location: ' . $base_path . '/vendedor/recoleccion?id=' . $cliente_id);
            exit();
        } else {
            $_SESSION['error'] = "Error al agendar la cita.";
            header('Location: ' . $base_path . '/vendedor/recoleccion?id=' . $cliente_id);
            exit();
        }
    } catch (PDOException $e) {
        // Si el error es por entrada duplicada (código 1062) se envía el mensaje
        if (isset($e->errorInfo[1]) && $e->errorInfo[1] == 1062) {
            $_SESSION['error'] = "El número de papeleta ya fue asignado a una cita.";
        } else {
            $_SESSION['error'] = "Error al agendar la cita: " . $e->getMessage();
        }
        header('Location: ' . $base_path . '/vendedor/recoleccion?id=' . $cliente_id);
        exit();
    }
}
?>
