<?php include '../header.php'; ?>

<div class="container mt-5">
    <h1 class="titulo-principal text-center mb-5">Registro de Cliente</h1>
    
    <form action="../../controllers/cliente_controller.php" method="POST" class="formulario-principal">
        <?php include '../partials/messages.php'; ?>
        
        <?php include '../partials/form_cliente.php'; ?>
        
        <div class="text-center mt-5">
            <button type="submit" class="btn btn-custom">Guardar Cliente</button>
        </div>
    </form>
</div>

<?php include '../footer.php'; ?>