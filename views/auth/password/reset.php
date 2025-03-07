<?php
require __DIR__ . '/../../models/database.php';

if (!isset($_GET['token'])) {
    echo "Token no proporcionado.";
    exit;
}

$token = $_GET['token'];

// Verificar si el token es válido y no ha expirado
$sql = "SELECT id FROM login WHERE token_recuperacion = :token AND token_expiracion > NOW()";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':token', $token);
$stmt->execute();

if ($stmt->rowCount() == 0) {
    echo "El enlace de recuperación es inválido o ha expirado.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    <link rel="stylesheet" href="/expo_v2/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/expo_v2/css/style.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">Restablecer Contraseña</h2>
                <form method="post" action="/expo_v2/auth/password/update-password">
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                    <div class="form-group">
                        <label for="password">Nueva Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirmar Contraseña</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Restablecer Contraseña</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>