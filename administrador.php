<?php
session_start();

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit();
}

if($_SESSION['rol'] != "admin"){
    echo "<script>
        alert('No tienes permiso para acceder al panel administrador');
        window.location.href='home.php';
    </script>";
    exit();
}

include "config/conexion.php";
include "acciones/verificar_subastas.php";

$total_usuarios = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM usuarios"));

$total_playeras = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM playeras"));

$total_ofertas = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM ofertas"));

$total_activas = mysqli_num_rows(mysqli_query($conexion, "
    SELECT * 
    FROM playeras 
    WHERE finalizada = 0 
    AND fecha_cierre > NOW()
"));

$total_finalizadas = mysqli_num_rows(mysqli_query($conexion, "
    SELECT * 
    FROM playeras 
    WHERE finalizada = 1
"));

$total_sin_ofertas = mysqli_num_rows(mysqli_query($conexion, "
    SELECT p.*
    FROM playeras p
    LEFT JOIN ofertas o
    ON p.id = o.playera_id
    WHERE o.id IS NULL
"));

$oferta_mayor = mysqli_query($conexion, "
    SELECT 
        o.monto,
        u.nombre AS usuario,
        p.equipo,
        p.temporada
    FROM ofertas o
    INNER JOIN usuarios u
    ON o.usuario_id = u.id
    INNER JOIN playeras p
    ON o.playera_id = p.id
    ORDER BY o.monto DESC
    LIMIT 1
");

$mayor = mysqli_fetch_assoc($oferta_mayor);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Panel Administrador</title>

<link rel="stylesheet" href="css/styles.css">
</head>

<body>

<div class="app-container">

    <img src="img/logo.png" class="logo" alt="Logo FutBid AI">

    <h1>Panel Administrador</h1>

    <div class="card">
        <h3>📋 Usuarios registrados</h3>
        <p><?php echo $total_usuarios; ?> usuarios</p>
    </div>

    <div class="card">
        <h3>⚽ Playeras publicadas</h3>
        <p><?php echo $total_playeras; ?> playeras</p>
    </div>

    <div class="card">
        <h3>💰 Ofertas realizadas</h3>
        <p><?php echo $total_ofertas; ?> ofertas</p>
    </div>

    <div class="card">
        <h3>🟢 Subastas activas</h3>
        <p><?php echo $total_activas; ?> subastas activas</p>
    </div>

    <div class="card">
        <h3>🏁 Subastas finalizadas</h3>
        <p><?php echo $total_finalizadas; ?> subastas finalizadas</p>
    </div>

    <div class="card">
        <h3>⚠️ Subastas sin ofertas</h3>
        <p><?php echo $total_sin_ofertas; ?> subastas sin ofertas</p>
    </div>

    <div class="card">
        <h3>🔥 Oferta más alta</h3>

        <?php if($mayor){ ?>

            <p>
                $<?php echo number_format($mayor['monto'],2); ?> MXN
            </p>

            <p>
                Usuario: <?php echo $mayor['usuario']; ?>
            </p>

            <p>
                Playera: <?php echo $mayor['equipo']; ?> <?php echo $mayor['temporada']; ?>
            </p>

        <?php }else{ ?>

            <p>No hay ofertas registradas.</p>

        <?php } ?>

    </div>

    <a href="admin_usuarios.php" class="btn secondary">
        📋 Ver usuarios
    </a>

    <a href="admin_playeras.php" class="btn secondary">
        ⚽ Ver playeras
    </a>

    <a href="admin_ofertas.php" class="btn secondary">
        💰 Ver ofertas
    </a>

    <a href="historial.php" class="btn secondary">
        🏁 Historial de subastas
    </a>
    <a href="admin_reportes.php" class="btn secondary">
        📊 Reportes generales
    </a>

    <a href="home.php" class="btn primary">
        Volver al inicio
    </a>

    <div class="bottom-nav">
        <a href="home.php">Inicio</a>
        <a href="subir.php">Subir</a>
        <a href="ofertas.php">Ofertas</a>
        <a href="perfil.php">Perfil</a>
    </div>

</div>

</body>
</html>