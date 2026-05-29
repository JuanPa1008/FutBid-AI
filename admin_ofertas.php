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

$ofertas = mysqli_query($conexion, "
    SELECT 
        o.id,
        o.monto,
        o.creado_en,
        u.nombre AS usuario,
        p.equipo,
        p.temporada
    FROM ofertas o
    INNER JOIN usuarios u ON o.usuario_id = u.id
    INNER JOIN playeras p ON o.playera_id = p.id
    ORDER BY o.id DESC
");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Ofertas</title>
<link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="app-container">

<img src="img/logo.png" class="logo">

<h1>Ofertas realizadas</h1>

<?php while($o = mysqli_fetch_assoc($ofertas)){ ?>

<div class="card">
    <h3>💰 Oferta #<?php echo $o['id']; ?></h3>
    <p>Usuario: <?php echo $o['usuario']; ?></p>
    <p>Playera: <?php echo $o['equipo']; ?> <?php echo $o['temporada']; ?></p>
    <p>Monto: $<?php echo number_format($o['monto'],2); ?> MXN</p>
    <p>Fecha: <?php echo $o['creado_en']; ?></p>
</div>

<?php } ?>

<a href="administrador.php" class="btn primary">Volver</a>

</div>

</body>
</html>