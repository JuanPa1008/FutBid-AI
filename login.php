<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">

<title>Login</title>

<link rel="stylesheet"
href="css/styles.css">

</head>

<body>

<div class="app-container">

<img src="img/logo.png"
class="logo">

<h1>
Bienvenido de nuevo
</h1>

<form
action="acciones/login.php"
method="POST">

<input
class="input"
name="correo"
placeholder="Correo electrónico"
required>

<input
class="input"
name="password"
placeholder="Contraseña"
type="password"
required>

<button
type="submit"
class="btn primary">

Entrar

</button>

</form>

<a
href="registro.php"
class="btn secondary">

¿No tienes cuenta?
Regístrate

</a>

</div>

</body>
</html>