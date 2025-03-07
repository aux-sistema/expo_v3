<?php
require __DIR__ . '/../../../vendor/autoload.php';
require __DIR__ . '/../../../models/database.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Verificar si el correo existe en la base de datos
    $sql = "SELECT id FROM login WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Generar un token único
        $token = bin2hex(random_bytes(32)); // Token seguro
        $expira = date("Y-m-d H:i:s", strtotime("+1 hour")); // Token expira en 1 hora

        // Guardar el token en la base de datos
        $sql = "UPDATE login SET token_recuperacion = :token, token_expiracion = :expira WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':expira', $expira);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Configurar PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->SMTPDebug = SMTP::DEBUG_OFF; // Cambia a DEBUG_OFF en producción
            $mail->Host       = 'smtp.gmail.com'; // Servidor SMTP de Gmail
            $mail->SMTPAuth   = true;
            $mail->Username   = 'armadodos1@gmail.com'; 
            $mail->Password   = '4rm4d0.09$'; // Usa una contraseña de aplicación
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Encriptación TLS
            $mail->Port       = 587; // Puerto SMTP para Gmail

            // Remitente y destinatario
            $mail->setFrom('no-reply@expojoya.com', 'ExpoJoya');
            $mail->addAddress($email); // Correo del usuario

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Recuperación de Contraseña';
            $mail->Body    = "Haz clic en el siguiente enlace para restablecer tu contraseña: 
                              <a href='http://localhost/expo_v2/auth/password/reset?token=$token'>Restablecer Contraseña</a>";

            $mail->send();
            echo "Se ha enviado un enlace de recuperación a tu correo.";
        } catch (Exception $e) {
            echo "Error al enviar el correo: {$mail->ErrorInfo}";
        }
    } else {
        echo "El correo no está registrado.";
    }
}
?>