<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Prohibido</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color:rgb(255, 255, 255);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        .container {
            max-width: 600px;
            padding: 20px;
        }

        .container img {
            width: 500px; 
            height: auto;
            margin-bottom: 20px;
        }

        .container h1 {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 10px;
        }

        .container p {
            font-size: 1.2rem;
            color: #666;
        }

        .container a {
            color: #007BFF;
            text-decoration: none;
        }

        .container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="/expo_v2/assets/img/403.jpg" alt="Error 404">
        <h1>Acceso Prohibido</h1>
        <p>No tienes permiso para acceder a esta página.</p>
        <a href="/expo_v2/login">Volver al inicio de sesión</a>
    </div>
</body>
</html>