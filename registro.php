<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registro</title>
<link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="app-container">
    <img src="img/logo.png" class="logo">

    <h1>Crear cuenta</h1>

    <form action="acciones/registrar.php" method="POST">
        <input class="input" name="nombre" placeholder="Nombre completo" required>
        <input class="input" name="correo" placeholder="Correo electrónico" required>
        <input class="input" name="password" placeholder="Contraseña" type="password" required>
        <input class="input" name="confirmar" placeholder="Confirmar contraseña" type="password" required>

        <button type="submit" class="btn primary">Crear cuenta</button>
    </form>

    <a href="login.php" class="btn secondary">
        ¿Ya tienes cuenta? Inicia sesión
    </a>
</div>

</body>
</html>