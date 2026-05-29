<?php
session_start();

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit();
}

include "config/conexion.php";
include "acciones/verificar_subastas.php";

$usuario_id = $_SESSION['id'];
$nombre = $_SESSION['nombre'];
$correo = $_SESSION['correo'];
$rol = $_SESSION['rol'];
$inicial = strtoupper(substr($nombre, 0, 1));

$ganadas = mysqli_query($conexion, "
    SELECT *
    FROM playeras
    WHERE ganador_id = '$usuario_id'
    AND finalizada = 1
    AND fecha_cierre >= DATE_SUB(NOW(), INTERVAL 10 MINUTE)
");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mi Perfil</title>
<link rel="stylesheet" href="css/styles.css">
</head>

<body>

<div class="app-container">

    <img src="img/logo.png" class="logo" alt="Logo FutBid AI">

    <h1>Mi Perfil</h1>

    <div class="profile-card">

        <div class="profile-photo">
            <span style="font-size:45px; font-weight:bold; color:#0B132B;">
                <?php echo $inicial; ?>
            </span>
        </div>

        <h3><?php echo $nombre; ?></h3>

        <p><?php echo $correo; ?></p>

        <?php if(mysqli_num_rows($ganadas) > 0){ ?>

            <div class="card" id="avisoGanador">

                <h3>🏆 Subasta ganada</h3>

                <?php while($g = mysqli_fetch_assoc($ganadas)){ ?>

                    <p>
                        Felicidades, ganaste la subasta de
                        <b>
                            Playera <?php echo $g['equipo']; ?> <?php echo $g['temporada']; ?>
                        </b>
                    </p>

                <?php } ?>

            </div>

        <?php } ?>

        <a href="home.php" class="btn secondary">
            Mis subastas
        </a>

        <a href="ofertas.php" class="btn secondary">
            Mis ofertas
        </a>

        <a href="historial.php" class="btn secondary">
            Historial de subastas
        </a>

        <a href="perfil.php" class="btn secondary">
            Configuración
        </a>

        <?php if($rol == "admin"){ ?>

            <a href="administrador.php" class="btn primary">
                Panel Administrador
            </a>

        <?php } ?>

        <a href="acciones/logout.php" class="btn secondary">
            Cerrar sesión
        </a>

    </div>

    <div class="bottom-nav">
        <a href="home.php">Inicio</a>
        <a href="subir.php">Subir</a>
        <a href="ofertas.php">Ofertas</a>
        <a href="perfil.php">Perfil</a>
    </div>

</div>

<script>
setTimeout(() => {
    const aviso = document.getElementById("avisoGanador");

    if(aviso){
        aviso.style.display = "none";
    }
}, 8000);
</script>

</body>
</html>