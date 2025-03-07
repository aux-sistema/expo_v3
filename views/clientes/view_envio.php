<?php
$hideMenu = true;
include __DIR__ . '/../header.php';

// Verifica que las variables $cliente y $facturacion estén definidas
if (!isset($cliente) || !is_array($cliente)) {
    die('Error: No se encontraron datos del cliente.');
}
?>

<div class="container mt-5">
    <h1 class="titulo-principal text-center mb-5">Datos de Envio</h1>

    <!-- Se asume que desde el controlador se envían las variables $cliente y $facturacion (si existen) -->
    <form action="<?php echo $base_path; ?>/clientes/controller" method="POST" class="formulario-principal">
        <?php include __DIR__ . '/../partials/messages.php'; ?>
        <?php include __DIR__ . '/../partials/form_envio.php'; ?>

        <!-- Campo oculto para identificar el cliente -->
        <input type="hidden" name="id" value="<?php echo $cliente['id'] ?? ''; ?>">
        <!-- Indicador para que el controlador realice la actualización (opcional, ya que es solo lectura) -->
        <input type="hidden" name="action" value="actualizar">

        <div class="text-center mt-5">
            <!-- Botón de regresar -->
            <a href="<?php echo $base_path; ?>/clientes/view" class="btn btn-custom"
                style="background:rgb(173, 57, 57); color: #ffffff;">Regresar</a>
        </div>
    </form>
</div>

<!-- Incluir jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Incluir DataTables si se usa (ajusta según necesites) -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $base_path; ?>/assets/js/scripts.js"></script>
<?php include __DIR__ . '/../footer.php'; ?>