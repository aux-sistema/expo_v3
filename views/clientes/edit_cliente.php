<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Cliente</title>
  <!-- Incluye el CSS de estilos -->
  <link rel="stylesheet" href="/expo_v2/assets/css/styles.css">
  <!-- Incluye el CSS de DataTables desde un CDN -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</head>
<body>
  <div class="container mt-5">
    <h1 class="titulo-principal text-center mb-5">Editar Cliente</h1>
    
    <form action="/expo_v2/controllers/cliente_controller.php" method="POST" class="formulario-principal">
      <?php include __DIR__ . '/../partials/messages.php'; ?>
      <?php include __DIR__ . '/../partials/edit_form_cliente.php'; ?>
      
      <!-- Campo oculto para identificar el cliente a actualizar -->
      <input type="hidden" name="id" value="<?php echo $cliente['id'] ?? ''; ?>">
      <!-- Indicador para que el controlador realice la actualización -->
      <input type="hidden" name="action" value="actualizar">
      
      <div class="text-center mt-5">
        <button type="submit" class="btn btn-custom">Actualizar Cliente</button>
        <a href="/expo_v2/views/clientes/view_cliente.php" class="btn btn-custom" style="background: #ccc; color: #000; margin-left: 10px;">Cancelar</a>
      </div>
    </form>
  </div>
  
  <!-- Incluir jQuery desde un CDN -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Incluir el JS de DataTables -->
  <script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <!-- Incluir el script JS para el comportamiento del formulario -->
  <script src="/expo_v2/assets/js/scripts.js"></script>
</body>
</html>
