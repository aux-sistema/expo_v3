<?php
$base_path = '/expo_v2';
include __DIR__ . '/../header_vendedor.php';

require_once __DIR__ . '/../../models/database.php';
require_once __DIR__ . '/../../models/papeleta.php';

$db = new Database();
$pdo = $db->getConnection();
$papeletaModel = new Papeleta($pdo);

$search = $_GET['search'] ?? '';
$order = $_GET['order'] ?? 'DESC';

$papeletas = $papeletaModel->getAll($search, $order);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Papeletas para Asignar Mesas</title>
</head>
<body>
<h2>Listado de Papeletas para Asignar Mesas</h2>

<form method="GET" action="<?php echo $base_path; ?>/vendedor/papeleta/mesa">
    <input type="text" name="search" placeholder="Buscar..." value="<?php echo htmlspecialchars($search); ?>">
    <select name="order">
        <option value="DESC" <?php echo ($order === 'DESC') ? 'selected' : ''; ?>>Más recientes</option>
        <option value="ASC" <?php echo ($order === 'ASC') ? 'selected' : ''; ?>>Más antiguos</option>
    </select>
    <button type="submit">Buscar</button>
</form>

<br>

<table border="1">
    <thead>
        <tr>
            <th>Folio</th>
            <th>Cliente</th>
            <th>Fecha Creación</th>
            <th>Mesa Asignada</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($papeletas as $p): ?>
            <tr>
                <td><?php echo $p['folio_papeleta']; ?></td>
                <td><?php echo $p['nom_completo']; ?></td>
                <td><?php echo $p['fecha_creacion']; ?></td>
                <td><?php echo !empty($p['id_mesa']) ? $p['id_mesa'] : 'No asignada'; ?></td>
                <td>
                    <a href="<?php echo $base_path; ?>/vendedor/papeleta/asignar_mesas?id=<?php echo $p['id_papeleta']; ?>">Asignar Mesa</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
<?php require_once __DIR__ . '/../footer_ventas.php'; ?>
