<?php include __DIR__ . '/../header_vendedor.php'; ?>

<div class="container mt-5">
    <h1 class="titulo-principal text-center mb-5">Listado de Papeletas</h1>
    <!-- Tabla de Papeletas -->
    <table id="papeletasTable" class="table table-striped">
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
            <!-- Los datos se cargarán vía AJAX con DataTables -->
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../footer_ventas.php'; ?>

<!-- Incluimos el script específico para la lista de papeletas -->
<script src="<?php echo $base_path; ?>/assets/js/script_papeletas.js"></script>
