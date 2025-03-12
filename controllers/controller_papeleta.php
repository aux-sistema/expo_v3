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
        'cliente_id'     => trim($_POST['cliente_id'] ?? ''),
        'folio_papeleta' => trim($_POST['folio_papeleta'] ?? ''),
        'metales'        => trim($_POST['metales'] ?? ''),
        'quien_atendio'  => trim($_POST['quien_atendio'] ?? ''),
        'tipo_entrega'   => trim($_POST['tipo_entrega'] ?? '')
    ];

    // Nuevo campo para saber si se necesita factura
    $necesitaFactura = trim($_POST['necesita_factura'] ?? 'no');

    $db = new Database();
    $pdo = $db->getConnection();
    $papeletaModel = new Papeleta($pdo);

    try {
        // Iniciar transacción para cubrir todo el proceso
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

        // 2. Procesar según el tipo de entrega
        if ($data['tipo_entrega'] === 'envio') {
            // Validar que el usuario aceptó la fecha de envío
            $aceptoEnvio = trim($_POST['acepto_envio'] ?? 'no');
            if ($aceptoEnvio !== 'si') {
                throw new Exception("No se guardó la papeleta: el usuario no aceptó la fecha de envío.");
            }

            // Procesar datos de envío
            $envioData = [
                'id_papeleta'     => $idPapeleta,
                'direccion_envio' => trim($_POST['direccion_envio'] ?? ''),
                // Campo opcional: fecha_envio, si se utiliza
                'fecha_envio'     => trim($_POST['fecha_envio'] ?? null)
            ];
            $envio = new Envio($pdo);
            if (!$envio->addEnvio($envioData)) {
                throw new Exception("Error al guardar los datos de envío.");
            }

        } elseif ($data['tipo_entrega'] === 'recoleccion') {
            // Validar campos obligatorios de recolección
            if (empty($_POST['fecha_recoleccion']) || empty($_POST['hora_recoleccion']) || empty($_POST['lugar_recoleccion'])) {
                throw new Exception("Para recolección, fecha, hora y lugar son obligatorios.");
            }
            $fecha = trim($_POST['fecha_recoleccion']);
            $hora  = trim($_POST['hora_recoleccion']);
            $lugar = trim($_POST['lugar_recoleccion']);

            // Procesar la parte de recolección: buscar o crear la cita y verificar cupos
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

            // Verificar cupos para la cita
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
                throw new Exception("Error al guardar los datos de recolección.");
            }
        }

        // Confirmar la transacción si todo salió bien
        $pdo->commit();

        // Actualizar la papeleta con el campo de factura (si es necesario)
        $stmt = $pdo->prepare("UPDATE papeletas SET necesita_factura = ? WHERE id_papeleta = ?");
        $stmt->execute([$necesitaFactura, $idPapeleta]);

        // Redirigir según si se requiere factura o no
        if ($necesitaFactura === 'si') {
            // Si se requiere factura, redirigir a la ruta de facturación
            header("Location: {$base_path}/vendedor/edit?id=" . $data['cliente_id']);
            exit();
        } else {
            header("Location: {$base_path}/vendedor/view_vendedor?id=" . $data['cliente_id']);
            exit();
        }

    } catch (PDOException $ex) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        if ($ex->getCode() == 23000) {
            $_SESSION['error'] = "El folio de la papeleta ya existe. Elige otro.";
        } else {
            $_SESSION['error'] = "Error de BD: " . $ex->getMessage();
        }
        header("Location: {$base_path}/vendedor/add_papeleta.php?id=" . $data['cliente_id']);
        exit();

    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        $_SESSION['error'] = $e->getMessage();
        header("Location: {$base_path}/vendedor/add_papeleta.php?id=" . $data['cliente_id']);
        exit();
    }

} else {
    header("Location: {$base_path}");
    exit();
}
?>
