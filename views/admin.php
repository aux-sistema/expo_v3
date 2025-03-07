<?php
require __DIR__ . '/auth/check_session.php'; 

header("Cache-Control: no-cache, no-store, must-revalidate"); 
header("Pragma: no-cache"); 
header("Expires: 0"); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="/expo_v2/assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/expo_v2/assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Bienvenido, Administrador</h1>
        <a href="/expo_v2/auth/logout" class="btn btn-primary">Cerrar sesión</a>
    </div>
</body>
</html>