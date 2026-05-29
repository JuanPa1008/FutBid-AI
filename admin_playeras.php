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
include "acciones/verificar_subastas.php";

$playeras = mysqli_query($conexion, "
    SELECT 
        p.*,
        u.nombre AS usuario,

        (
            SELECT MAX(o.monto)
            FROM ofertas o
            WHERE o.playera_id = p.id
        ) AS oferta_actual,

        (
            SELECT u2.nombre
            FROM ofertas o2
            INNER JOIN usuarios u2 ON o2.usuario_id = u2.id
            WHERE o2.playera_id = p.id
            ORDER BY o2.monto DESC
            LIMIT 1
        ) AS usuario_ganador

    FROM playeras p
    LEFT JOIN usuarios u ON p.usuario_id = u.id
    ORDER BY p.id DESC
");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Playeras</title>
<link rel="stylesheet" href="css/styles.css">
</head>

<body>

<div class="app-container">

<img src="img/logo.png" class="logo">

<h1>Playeras publicadas</h1>

<?php while($p = mysqli_fetch_assoc($playeras)){ ?>

<?php
$ofertaActual = $p['oferta_actual'] ? $p['oferta_actual'] : $p['precio_inicial'];
?>

<div class="card">

<h3>⚽ <?php echo $p['equipo']; ?> <?php echo $p['temporada']; ?></h3>

<img src="<?php echo $p['imagen']; ?>" class="jersey-img">

<p>Jugador: <?php echo $p['jugador']; ?></p>

<p>Talla: <?php echo $p['talla']; ?></p>

<p>Precio inicial: $<?php echo number_format($p['precio_inicial'],2); ?> MXN</p>

<?php if($p['finalizada'] == 1){ ?>

<p>
🏆 Precio final:
$<?php echo number_format($ofertaActual,2); ?> MXN
</p>

<p>
Ganador:
<?php echo $p['usuario_ganador'] ? $p['usuario_ganador'] : "Sin ofertas"; ?>
</p>

<p>Estado: Finalizada</p>

<?php }else{ ?>

<p>
🔥 Oferta actual:
$<?php echo number_format($ofertaActual,2); ?> MXN
</p>

<p>
Va ganando:
<?php echo $p['usuario_ganador'] ? $p['usuario_ganador'] : "Sin ofertas"; ?>
</p>

<p>Estado: Activa</p>

<?php } ?>

<p>Publicado por: <?php echo $p['usuario']; ?></p>

</div>

<?php } ?>

<a href="administrador.php" class="btn primary">Volver</a>

</div>

</body>
</html>