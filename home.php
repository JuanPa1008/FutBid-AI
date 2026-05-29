<?php
session_start();

include "config/conexion.php";
include "acciones/verificar_subastas.php";

$consulta = "
SELECT 
    p.*,

    (
        SELECT MAX(o.monto)
        FROM ofertas o
        WHERE o.playera_id = p.id
    ) AS oferta_actual,

    (
        SELECT u.nombre
        FROM ofertas o
        INNER JOIN usuarios u ON o.usuario_id = u.id
        WHERE o.playera_id = p.id
        ORDER BY o.monto DESC
        LIMIT 1
    ) AS usuario_ganando

FROM playeras p

WHERE p.finalizada = 0
AND p.fecha_cierre > NOW()

ORDER BY p.id DESC
";

$resultado = mysqli_query($conexion, $consulta);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Home</title>
<link rel="stylesheet" href="css/styles.css">
</head>

<body>

<div class="app-container">

<img src="img/logo.png" class="logo">

<h1>Subastas activas</h1>

<input class="input" placeholder="🔍 Buscar playera...">

<?php if(mysqli_num_rows($resultado) > 0){ ?>

<?php while($playera = mysqli_fetch_assoc($resultado)){ ?>

<?php
$ofertaActual = $playera['oferta_actual'] ? $playera['oferta_actual'] : $playera['precio_inicial'];
$usuarioGanando = $playera['usuario_ganando'] ? $playera['usuario_ganando'] : "Sin ofertas";
?>

<div class="auction-card">

<img 
src="<?php echo $playera['imagen']; ?>" 
class="jersey-img" 
alt="Playera">

<div class="auction-info">

<h3>
Playera <?php echo $playera['equipo']; ?> <?php echo $playera['temporada']; ?>
</h3>

<p class="price">
💰 Oferta actual: $<?php echo number_format($ofertaActual,2); ?> MXN
</p>

<p>
👤 Va ganando: <?php echo $usuarioGanando; ?>
</p>

<p>
⏳ Tiempo restante:
<span 
class="contador"
data-fecha="<?php echo $playera['fecha_cierre']; ?>">
Cargando...
</span>
</p>

<p>
⭐ Autenticidad: <?php echo $playera['autenticidad']; ?>%
</p>

<a 
href="detalle.php?id=<?php echo $playera['id']; ?>" 
class="small-btn">
Ofertar más
</a>

</div>

</div>

<?php } ?>

<?php }else{ ?>

<div class="card">
<p>No hay subastas activas por el momento.</p>
</div>

<?php } ?>

<div class="bottom-nav">
<a href="home.php">Inicio</a>
<a href="subir.php">Subir</a>
<a href="ofertas.php">Ofertas</a>
<a href="perfil.php">Perfil</a>
</div>

</div>

<script>
function actualizarContadores(){

    const contadores = document.querySelectorAll(".contador");

    contadores.forEach(contador => {

        const fechaCierre = new Date(contador.dataset.fecha).getTime();
        const ahora = new Date().getTime();
        const diferencia = fechaCierre - ahora;

        if(diferencia <= 0){
            contador.innerHTML = "Finalizada 🏁";
            contador.style.color = "red";
            return;
        }

        const horas = Math.floor((diferencia / (1000 * 60 * 60)) % 24);
        const minutos = Math.floor((diferencia / (1000 * 60)) % 60);
        const segundos = Math.floor((diferencia / 1000) % 60);

        contador.innerHTML =
        String(horas).padStart(2,'0') + ":" +
        String(minutos).padStart(2,'0') + ":" +
        String(segundos).padStart(2,'0');
    });
}

actualizarContadores();
setInterval(actualizarContadores,1000);
</script>

</body>
</html>