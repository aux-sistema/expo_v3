<?php include __DIR__ . '/../header_vendedor.php';
if (!defined('PROTECTED_ACCESS')) {
    header('Location: /expo_v2/403');
    exit();
} ?>

<div class="container mt-5">
    <h1 class="titulo-principal text-center mb-5">Registro de Papeleta</h1>

    <form action="<?php echo $base_path; ?>/vendedor/controller" method="POST" class="formulario-principal">
        <?php include __DIR__ . '/../partials/messages.php'; ?>
        <?php include __DIR__ . '/../partials/form_papeleta.php'; ?>
    </form>
</div>
<script src="<?php echo $base_path; ?>/assets/js/scripts-ventas.js"></script>

