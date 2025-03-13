<?php
// views/mesa/asignar_mesa.php
$base_path = '/expo_v2';

require_once __DIR__ . '/../../models/database.php';
require_once __DIR__ . '/../../models/papeleta.php';
require_once __DIR__ . '/../../models/mesa.php';

$db = new Database();
$pdo = $db->getConnection();
$papeletaModel = new Papeleta($pdo);
$mesaModel = new Mesa($pdo);

$idPapeleta = $_GET['id'] ?? null;
if (!$idPapeleta) {
    echo "No se especificó la papeleta.";
    exit();
}

$papeleta = $papeletaModel->getById($idPapeleta);
$mesas = $mesaModel->getAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Mesa a la Papeleta</title>
</head>
<body>
<h2>Asignar Mesa a la Papeleta</h2>

<p>
    <strong>Folio:</strong> <?php echo $papeleta['folio_papeleta']; ?><br>
    <strong>ID Cliente:</strong> <?php echo $papeleta['id_cliente']; ?>
</p>

<form method="POST" action="<?php echo $base_path; ?>/vendedor/papeleta/mesas">
    <input type="hidden" name="id_papeleta" value="<?php echo $papeleta['id_papeleta']; ?>">
    <label for="id_mesa">Seleccionar Mesa:</label>
    <select name="id_mesa" id="id_mesa">
        <?php foreach ($mesas as $m): ?>
            <option value="<?php echo $m['id_mesa']; ?>">
                <?php echo $m['nombre_mesa']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Asignar Mesa</button>
</form>
</body>
</html>
