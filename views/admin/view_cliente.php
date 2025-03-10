<?php include __DIR__ . '/../header.php'; 
if (!defined('PROTECTED_ACCESS')) {
    header('Location: /expo_v2/403');
    exit();
}?>

<div class="container mt-5">
    <h1 class="titulo-principal text-center mb-5">Lista de Clientes</h1>
    <!-- Tabla de Clientes -->
    <table id="clientesTable" class="table table-striped">
        <thead>
            <tr>
                <th>No. Cliente</th>
                <th>Nombre Completo</th>
                <th>Teléfono</th>
                <th>Estado</th>
                <th>Factura</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Los datos se cargarán aquí con JavaScript -->
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../footer.php'; ?>