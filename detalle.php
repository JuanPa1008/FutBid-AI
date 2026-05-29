<?php
session_start();

include "config/conexion.php";
include "acciones/verificar_subastas.php";

$id = isset($_GET['id']) ? $_GET['id'] : 0;

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
WHERE p.id = '$id'
";

$resultado = mysqli_query($conexion, $consulta);
$playera = mysqli_fetch_assoc($resultado);

$ofertaActual = $playera['oferta_actual'] ? $playera['oferta_actual'] : $playera['precio_inicial'];
$usuarioGanando = $playera['usuario_ganando'] ? $playera['usuario_ganando'] : "Sin ofertas";
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Detalle Subasta</title>
<link rel="stylesheet" href="css/styles.css">
</head>

<body>

<div class="app-container">

<img src="img/logo.png" class="logo">

<img src="<?php echo $playera['imagen']; ?>" class="jersey-detail">

<h2>Playera <?php echo $playera['equipo']; ?> <?php echo $playera['temporada']; ?></h2>

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

<form action="acciones/ofertar.php" method="POST">

<input type="hidden" name="playera_id" value="<?php echo $playera['id']; ?>">

<input
id="oferta"
name="monto"
type="number"
class="input"
placeholder="Ingresa tu oferta"
min="<?php echo $ofertaActual + 1; ?>"
required>

<button type="submit" class="btn primary">
Ofertar ahora
</button>

</form>

<div class="ia-card">

<h3>🤖 Análisis IA</h3>

<p>Autenticidad: <?php echo $playera['autenticidad']; ?>%</p>
<p>Rareza: <?php echo $playera['rareza']; ?></p>
<p>Valor estimado: <?php echo $playera['precio_sugerido']; ?></p>
<p>Recomendación: Buena oportunidad</p>

</div>

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