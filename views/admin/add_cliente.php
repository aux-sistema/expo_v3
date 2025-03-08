<?php include __DIR__ . '/../header.php'; 
if (!defined('PROTECTED_ACCESS')) {
    header('Location: /expo_v2/403');
    exit();
}?>

<div class="container mt-5">
    <h1 class="titulo-principal text-center mb-5">Registro de Cliente</h1>
    
    <form action="<?php echo $base_path; ?>/admin/controller" method="POST" class="formulario-principal">
        <?php include __DIR__ . '/../partials/messages.php'; ?>
        <?php include __DIR__ . '/../partials/form_cliente.php'; ?>
        <div class="text-center mt-5">
            <button type="submit" class="btn btn-custom">Guardar Cliente</button>
        </div>
    </form>
</div>
<script src="<?php echo $base_path; ?>/assets/js/scripts.js"></script>

<?php include __DIR__ . '/../footer.php'; ?>
