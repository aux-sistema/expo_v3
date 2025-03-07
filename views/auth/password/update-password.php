<?php
require __DIR__ . '/../../models/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo "Las contraseñas no coinciden.";
        exit;
    }

    $sql = "SELECT id FROM login WHERE token_recuperacion = :token AND token_expiracion > NOW()";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':token', $token);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE login SET password = :password, token_recuperacion = NULL, token_expiracion = NULL WHERE token_recuperacion = :token";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':token', $token);
        $stmt->execute();

        echo "Contraseña actualizada correctamente. <a href='/expo_v2/login'>Iniciar sesión</a>";
    } else {
        echo "El enlace de recuperación es inválido o ha expirado.";
    }
}
?>