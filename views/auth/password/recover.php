<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="/expo_v2/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/expo_v2/css/style.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">Recuperar Contraseña</h2>
                <form method="post" action="/expo_v2/auth/password/reset_password">
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Enviar Enlace</button>
                </form>
                <div class="text-center mt-3">
                    <a href="/expo_v2/login">Volver al inicio de sesión</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>