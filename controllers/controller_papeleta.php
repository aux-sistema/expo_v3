<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../models/database.php';
require_once __DIR__ . '/../models/papeleta.php';
require_once __DIR__ . '/../models/envio.php';
require_once __DIR__ . '/../models/cita.php';
require_once __DIR__ . '/../models/recoleccion.php';

$base_path = '/expo_v2';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Datos generales de la papeleta
    $data = [
        'cliente_id'     => $_POST['cliente_id']     ?? '',
        'folio_papeleta' => $_POST['folio_papeleta'] ?? '',
        'metales'        => $_POST['metales']        ?? '',
        'quien_atendio'  => $_POST['quien_atendio']  ?? '',
        'tipo_entrega'   => $_POST['tipo_entrega']   ?? ''
    ];

    $db = new Database();
    $pdo = $db->getConnection();
    $papeletaModel = new Papeleta($pdo);

    try {
        // Iniciar UNA sola transacción que cubra todo el proceso
        $pdo->beginTransaction();

        // 1. Insertar la papeleta
        if (!$papeletaModel->addPapeleta($data)) {
            throw new Exception("Error al insertar la papeleta.");
        }

        $idPapeleta = $pdo->lastInsertId();
        if ($idPapeleta <= 0) {
            throw new Exception("No se pudo obtener el ID de la papeleta.");
        }

        $_SESSION['mensaje'] = 'Papeleta registrada correctamente.';

        // 2. Según el tipo de entrega, procesar
        if ($data['tipo_entrega'] === 'envio') {
            // Datos de envío
            $envioData = [
                'id_papeleta'     => $idPapeleta,
                'direccion_envio' => $_POST['direccion_envio'] ?? ''
            ];
            $envio = new Envio($pdo);
            if (!$envio->addEnvio($envioData)) {
                throw new Exception("Error al guardar los datos de envío.");
            }

        } elseif ($data['tipo_entrega'] === 'recoleccion') {
            // Validar campos de recolección
            if (empty($_POST['fecha_recoleccion']) || empty($_POST['hora_recoleccion']) || empty($_POST['lugar_recoleccion'])) {
                throw new Exception("Para recolección, fecha, hora y lugar son obligatorios.");
            }
            $fecha = $_POST['fecha_recoleccion'];
            $hora  = $_POST['hora_recoleccion'];
            $lugar = $_POST['lugar_recoleccion'];

            // Crear/usar cita y verificar cupos
            $citaModel = new Cita($pdo);
            $cita = $citaModel->getCita($fecha, $hora);
            if (!$cita) {
                $nuevoIdCita = $citaModel->createCita($fecha, $hora, 5);
                if (!$nuevoIdCita) {
                    throw new Exception("Error al crear la cita de recolección.");
                }
                $cita = $citaModel->getCita($fecha, $hora);
                if (!$cita || empty($cita['id_cita'])) {
                    throw new Exception("No se pudo obtener el ID de la cita tras crearla.");
                }
            }
            if (empty($cita['id_cita'])) {
                throw new Exception("La cita encontrada no tiene ID definido.");
            }
            $id_cita = $cita['id_cita'];

            // Verificar cupos
            $count = $citaModel->countRecolecciones($id_cita);
            if ($count >= $cita['cupos']) {
                throw new Exception("No hay cupo para la fecha y hora seleccionadas.");
            }

            // Insertar la recolección
            $recoleccionData = [
                'id_papeleta'       => $idPapeleta,
                'id_cita'           => $id_cita,
                'fecha_recoleccion' => $fecha,
                'hora_recoleccion'  => $hora,
                'lugar_recoleccion' => $lugar
            ];
            $recoleccion = new Recoleccion($pdo);
            if (!$recoleccion->addRecoleccion($recoleccionData)) {
                throw new Exception("Error al guardar la recolección.");
            }
        }

        // 3. Si todo salió bien, COMMIT. Se guardan papeleta y envío/recolección.
        $pdo->commit();

        // Redirigir al final
        header("Location: {$base_path}/vendedor/add_papeleta?id={$data['cliente_id']}");
        exit();

    } catch (PDOException $ex) {
        // Manejo específico de errores PDO (p.ej. folio repetido)
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        if ($ex->getCode() == 23000) {
            $_SESSION['error'] = "El folio de la papeleta ya existe. Elige otro.";
        } else {
            $_SESSION['error'] = "Error de BD: " . $ex->getMessage();
        }
        header("Location: {$base_path}/vendedor/add_papeleta?id={$data['cliente_id']}");
        exit();

    } catch (Exception $e) {
        // Cualquier otro error
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        $_SESSION['error'] = $e->getMessage();
        header("Location: {$base_path}/vendedor/add_papeleta?id={$data['cliente_id']}");
        exit();
    }

} else {
    header("Location: {$base_path}");
    exit();
}
?>
