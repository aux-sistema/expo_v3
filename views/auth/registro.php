<?php
require_once __DIR__ . '/../../models/database.php';

// Crear una instancia de la clase Database y obtener la conexión
$database = new Database();
$conn = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario']; 
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password']; // Nueva variable para confirmar contraseña
    $id_cargo = $_POST['id_cargo']; 

    // Validaciones
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Formato de correo electrónico no válido.";
        exit;
    }

    if (empty($usuario)) {
        echo "El nombre de usuario es obligatorio.";
        exit;
    }

    if (strlen($password) < 8) {
        echo "La contraseña debe tener al menos 8 caracteres.";
        exit;
    }

    if ($password !== $confirm_password) {
        echo "Las contraseñas no coinciden.";
        exit;
    }

    // Hash de la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO login (usuario, email, password, id_cargo) VALUES (:usuario, :email, :password, :id_cargo)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':id_cargo', $id_cargo, PDO::PARAM_INT);
        $stmt->execute();

        echo "Usuario registrado correctamente.";
    } catch (PDOException $e) {
        echo "Error al registrar el usuario: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            max-width: 400px;
            margin: 0 auto;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .password-strength {
            margin-top: 5px;
            font-size: 14px;
        }
        .password-strength span {
            font-weight: bold;
        }
        .password-match {
            margin-top: 5px;
            font-size: 14px;
        }
        .password-match.valid {
            color: green;
        }
        .password-match.invalid {
            color: red;
        }
    </style>
</head>
<body>
    <h1>Registro de Usuario</h1>
    <form method="post" action="">
        <div>
            <label for="usuario">Nombre de Usuario:</label>
            <input type="text" id="usuario" name="usuario" required>
        </div>
        <div>
            <label for="email">Correo:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" minlength="8" required>
            <div class="password-strength">
                Fortaleza de la contraseña: <span id="strength-text">Débil</span>
                <div id="strength-bar" style="height: 5px; width: 0%; background-color: red;"></div>
            </div>
        </div>
        <div>
            <label for="confirm_password">Confirmar Contraseña:</label>
            <input type="password" id="confirm_password" name="confirm_password" minlength="8" required>
            <div class="password-match" id="password-match-text">Las contraseñas no coinciden.</div>
        </div>
        <div>
            <label for="id_cargo">Rol:</label>
            <select id="id_cargo" name="id_cargo" required>
                <option value="1">Admin</option>
                <option value="2">Vendedor</option>
                <option value="3">Cliente</option>
            </select>
        </div>
        <button type="submit">Registrarse</button>
    </form>

    <script>
        // Función para verificar la fortaleza de la contraseña
        function checkPasswordStrength(password) {
            let strength = 0;
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;

            let strengthText = '';
            let strengthColor = '';
            switch (strength) {
                case 0:
                case 1:
                    strengthText = 'Débil';
                    strengthColor = 'red';
                    break;
                case 2:
                    strengthText = 'Moderada';
                    strengthColor = 'orange';
                    break;
                case 3:
                    strengthText = 'Fuerte';
                    strengthColor = 'yellow';
                    break;
                case 4:
                case 5:
                    strengthText = 'Muy fuerte';
                    strengthColor = 'green';
                    break;
            }

            document.getElementById('strength-text').textContent = strengthText;
            document.getElementById('strength-bar').style.width = (strength * 20) + '%';
            document.getElementById('strength-bar').style.backgroundColor = strengthColor;
        }

        // Función para verificar si las contraseñas coinciden
        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const matchText = document.getElementById('password-match-text');

            if (password === confirmPassword && password.length >= 8) {
                matchText.textContent = 'Las contraseñas coinciden.';
                matchText.classList.remove('invalid');
                matchText.classList.add('valid');
            } else {
                matchText.textContent = 'Las contraseñas no coinciden.';
                matchText.classList.remove('valid');
                matchText.classList.add('invalid');
            }
        }

        // Event listeners
        document.getElementById('password').addEventListener('input', function() {
            checkPasswordStrength(this.value);
            checkPasswordMatch();
        });

        document.getElementById('confirm_password').addEventListener('input', checkPasswordMatch);
    </script>
</body>
</html>