<?php
require_once __DIR__ . '/../../models/database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Crear la conexión a la base de datos
$database = new Database();
$conn = $database->getConnection();

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: /admin/add.php');
    exit();
}

if (!isset($_SESSION['intentos'])) {
    $_SESSION['intentos'] = 0;
}

$max_intentos = 9; 
$tiempo_bloqueo = 300; 
$login_error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_SESSION['intentos'] >= $max_intentos) {
        if (isset($_SESSION['last_attempt'])) {
            $tiempo_transcurrido = time() - $_SESSION['last_attempt'];

            if ($tiempo_transcurrido < $tiempo_bloqueo) {
                $login_error = "Has excedido el número máximo de intentos. Por favor, espera 5 minutos antes de intentar nuevamente.";
            } else {
                $_SESSION['intentos'] = 0;
            }
        }
    }

    if ($_SESSION['intentos'] < $max_intentos) {
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];

        try {
            $sql = "SELECT login.id, login.usuario, login.password, login.id_cargo, rol.privilegio 
                    FROM login 
                    JOIN rol ON login.id_cargo = rol.id 
                    WHERE login.usuario = :usuario";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if (password_verify($password, $row['password'])) {
                    $_SESSION['intentos'] = 0;

                    $_SESSION['loggedin'] = true;
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['usuario'] = $row['usuario'];
                    $_SESSION['id_cargo'] = $row['id_cargo'];
                    $_SESSION['privilegio'] = $row['privilegio'];

                    switch ($row['id_cargo']) {
                        case 1:
                            header('Location: /expo_v2/admin');
                            break;
                        case 2:
                            header('Location: /expo_v2/vendedor');
                            break;
                        case 3:
                            header('Location: /expo_v2/cliente');
                            break;
                        default:
                            header('Location: /expo_v2/404');
                            break;
                    }
                    exit;
                } else {
                    $_SESSION['intentos']++;
                    $login_error = "Credenciales incorrectas. Intentos restantes: " . ($max_intentos - $_SESSION['intentos']);
                }
            } else {
                $_SESSION['intentos']++;
                $login_error = "Usuario no encontrado. Intentos restantes: " . ($max_intentos - $_SESSION['intentos']);
            }
        } catch (PDOException $e) {
            error_log("Error en el login: " . $e->getMessage());
            $login_error = "Ocurrió un error al intentar iniciar sesión. Por favor, inténtalo de nuevo más tarde.";
        }
        $_SESSION['last_attempt'] = time();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <link rel="stylesheet" href="/expo_v2/assets/css/bootstrap.css">
   <link rel="stylesheet" type="text/css" href="/expo_v2/assets/css/style.css">
   <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
   <link href="https://tresplazas.com/web/img/big_punto_de_venta.png" rel="shortcut icon">
   <title>Inicio de sesión</title>
</head>
<body>
    <img class="wave" src="/expo_v2/assets/img/wave.jpg">
   <div class="container">
      <div class="img">
         <!-- Imagen de fondo o ilustración -->
      </div>
      <div class="login-content">
         <form method="post" action="">
            <img src="/expo_v2/assets/img/avatar.png">
            <h2 class="title">WELCOME</h2>
            <?php if (!empty($login_error)): ?>
                <div class="alert alert-danger"><?php echo $login_error; ?></div>
            <?php endif; ?>
            <div class="input-div one">
               <div class="i">
                  <i class="fas fa-user"></i>
               </div>
               <div class="div">
                  <h5>Usuario</h5> 
                  <input id="usuario" type="text" class="input" name="usuario" required>
               </div>
            </div>
            <div class="input-div pass">
               <div class="i">
                  <i class="fas fa-lock"></i>
               </div>
               <div class="div">
                  <h5>Contraseña</h5>
                  <input type="password" id="input" class="input" name="password" required>
               </div>
            </div>
            <div class="view">
               <div class="fas fa-eye verPassword" onclick="vista()" id="verPassword"></div>
            </div>

            <div class="text-center">
               <a class="font-italic isai5" href="/expo_v2/registro">Registrarse</a>
            </div>
            <input name="btningresar" class="btn" type="submit" value="INICIAR SESION">
         </form>
      </div>
   </div>
   <script src="/expo_v2/assets/js/fontawesome.js"></script>
   <script src="/expo_v2/assets/js/main.js"></script>
   <script src="/expo_v2/assets/js/main2.js"></script>
   <script src="/expo_v2/assets/js/jquery.min.js"></script>
   <script src="/expo_v2/assets/js/bootstrap.js"></script>
   <script src="/expo_v2/assets/js/bootstrap.bundle.js"></script>

   <script>
   function vista() {
       var x = document.getElementById("input");
       if (x.type === "password") {
           x.type = "text";
       } else {
           x.type = "password";
       }
   }
   </script>
</body>
</html>
