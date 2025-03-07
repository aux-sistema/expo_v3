<?php
require __DIR__ . '/auth/check_session.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Cliente</title>
    <link rel="stylesheet" href="/expo_v2/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/expo_v2/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Bienvenido, Cliente</h1>
        <a href="/expo_v2/auth/logout">Cerrar sesión</a>
    </div>
</body>
</html>