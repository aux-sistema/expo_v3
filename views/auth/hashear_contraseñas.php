<?php
require 'models/database.php';
$password = "contraseña_de_prueba";
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
echo "Contraseña hasheada: " . $hashed_password;

try {
    $email = "usuario@example.com"; 
    $sql = "UPDATE login SET password = :password WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    echo "<br>Contraseña actualizada correctamente.";
} catch (PDOException $e) {
    echo "<br>Error al actualizar la contraseña: " . $e->getMessage();
}
?>