<?php
session_start();

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit();
}

include "config/conexion.php";
include "acciones/verificar_subastas.php";

$historial = mysqli_query($conexion, "

SELECT 
    p.*,
    u.nombre AS ganador,

    (
        SELECT MAX(o.monto)
        FROM ofertas o
        WHERE o.playera_id = p.id
    ) AS precio_final

FROM playeras p

LEFT JOIN usuarios u
ON p.ganador_id = u.id

WHERE p.finalizada = 1

ORDER BY p.fecha_cierre DESC

");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Historial de subastas</title>

<link rel="stylesheet" href="css/styles.css">
</head>

<body>

<div class="app-container">

    <img src="img/logo.png" class="logo" alt="Logo FutBid AI">

    <h1>Historial de subastas</h1>

    <?php if(mysqli_num_rows($historial) > 0){ ?>

        <?php while($h = mysqli_fetch_assoc($historial)){ ?>

            <div class="card">

                <h3>
                    ⚽ Playera <?php echo $h['equipo']; ?> <?php echo $h['temporada']; ?>
                </h3>

                <p>
                    🏁 Subasta finalizada
                </p>

                <p>
                    🏆 Ganador:
                    <?php echo $h['ganador'] ? $h['ganador'] : "Sin ofertas"; ?>
                </p>

                <p>
                    💰 Precio inicial:
                    $<?php echo number_format($h['precio_inicial'],2); ?> MXN
                </p>

                <p>
                    🏆 Precio final:
                    <?php
                    if($h['precio_final']){
                        echo "$".number_format($h['precio_final'],2)." MXN";
                    }else{
                        echo "Sin ofertas";
                    }
                    ?>
                </p>

                <p>
                    📅 Finalizó:
                    <?php echo $h['fecha_cierre']; ?>
                </p>

            </div>

        <?php } ?>

    <?php }else{ ?>

        <div class="card">
            <p>No hay subastas finalizadas por el momento.</p>
        </div>

    <?php } ?>

    <div class="bottom-nav">
        <a href="home.php">Inicio</a>
        <a href="subir.php">Subir</a>
        <a href="ofertas.php">Ofertas</a>
        <a href="perfil.php">Perfil</a>
    </div>

</div>

</body>
</html>