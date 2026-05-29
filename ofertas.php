<?php
session_start();

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit();
}

include "config/conexion.php";
include "acciones/verificar_subastas.php";

$usuario_id = $_SESSION['id'];

$consulta = "

SELECT 
o.id,
o.monto,

p.id AS playera_id,
p.equipo,
p.temporada,
p.fecha_cierre,

(
SELECT MAX(o2.monto)
FROM ofertas o2
WHERE o2.playera_id=p.id
) AS oferta_mas_alta

FROM ofertas o

INNER JOIN playeras p
ON o.playera_id=p.id

WHERE o.usuario_id='$usuario_id'

AND o.id=(

SELECT MAX(o3.id)

FROM ofertas o3

WHERE o3.usuario_id='$usuario_id'
AND o3.playera_id=p.id

)

AND p.finalizada=0

ORDER BY o.id DESC

";

$resultado = mysqli_query($conexion,$consulta);

?>

<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Mis Ofertas</title>

<link rel="stylesheet" href="css/styles.css">

</head>

<body>

<div class="app-container">

<img src="img/logo.png" class="logo">

<h1>Mis Ofertas</h1>

<?php if(mysqli_num_rows($resultado)>0){ ?>

<?php while($oferta=mysqli_fetch_assoc($resultado)){ ?>

<?php
$vasGanando=($oferta['monto'] >= $oferta['oferta_mas_alta']);
?>

<div class="card">

<h3>
⚽ Playera
<?php echo $oferta['equipo']; ?>
<?php echo $oferta['temporada']; ?>
</h3>

<p>
💰 Tu oferta:
$<?php echo number_format($oferta['monto'],2); ?>
MXN
</p>

<p>
🔥 Oferta más alta:
$<?php echo number_format($oferta['oferta_mas_alta'],2); ?>
MXN
</p>

<?php if($vasGanando){ ?>

<p style="color:#00A86B;">
🟢 Estado: Vas ganando
</p>

<?php } else { ?>

<p style="color:#EF4444;">
🔴 Estado: Vas perdiendo
</p>

<?php } ?>

<p>
⏳ Tiempo restante:
<span
class="contador"
data-fecha="<?php echo $oferta['fecha_cierre']; ?>">
Cargando...
</span>
</p>

</div>

<?php } ?>

<?php }else{ ?>

<div class="card">

<p>
No tienes ofertas activas
</p>

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

const contadores=document.querySelectorAll(".contador");

contadores.forEach(contador=>{

const fechaCierre=new Date(
contador.dataset.fecha
).getTime();

const ahora=new Date().getTime();

const diferencia=fechaCierre-ahora;

if(diferencia<=0){

contador.innerHTML="Finalizada 🏁";
contador.style.color="red";

return;

}

const horas=Math.floor(
(diferencia/(1000*60*60))%24
);

const minutos=Math.floor(
(diferencia/(1000*60))%60
);

const segundos=Math.floor(
(diferencia/1000)%60
);

contador.innerHTML=
String(horas).padStart(2,'0')
+":"
+String(minutos).padStart(2,'0')
+":"
+String(segundos).padStart(2,'0');

});

}

actualizarContadores();

setInterval(
actualizarContadores,
1000
);

</script>

</body>
</html>