<?php
session_start();

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit();
}

if($_SESSION['rol'] != "admin"){
    header("Location: home.php");
    exit();
}

include "config/conexion.php";

$usuarios = mysqli_query($conexion, "
    SELECT id, nombre, correo, rol, creado_en
    FROM usuarios
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Usuarios</title>
<link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="app-container">

<img src="img/logo.png" class="logo">

<h1>Usuarios registrados</h1>

<?php while($u = mysqli_fetch_assoc($usuarios)){ ?>

<div class="card">
    <h3>👤 <?php echo $u['nombre']; ?></h3>
    <p>Correo: <?php echo $u['correo']; ?></p>
    <p>Rol: <?php echo $u['rol']; ?></p>
    <p>Registro: <?php echo $u['creado_en']; ?></p>
</div>

<?php } ?>

<a href="administrador.php" class="btn primary">Volver</a>

</div>

</body>
</html>