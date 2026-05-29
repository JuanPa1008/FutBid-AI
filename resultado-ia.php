<?php
$equipo = isset($_GET['equipo']) ? $_GET['equipo'] : "No detectado";
$temporada = isset($_GET['temporada']) ? $_GET['temporada'] : "No especificada";
$estado = isset($_GET['estado']) ? $_GET['estado'] : "Bueno";
$autenticidad = isset($_GET['autenticidad']) ? $_GET['autenticidad'] : "90";
$rareza = isset($_GET['rareza']) ? $_GET['rareza'] : "Media";
$precio = isset($_GET['precio']) ? $_GET['precio'] : "$1,000 - $1,500";
$riesgo = isset($_GET['riesgo']) ? $_GET['riesgo'] : "Medio";
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Resultado IA</title>
<link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="app-container">

<img src="img/logo.png" class="logo">

<h1>Análisis completado</h1>

<div class="ia-card">

<h3>🤖 Resultado IA</h3>

<p><b>Equipo detectado:</b> <?php echo htmlspecialchars($equipo); ?></p>
<p><b>Temporada:</b> <?php echo htmlspecialchars($temporada); ?></p>
<p><b>Estado:</b> <?php echo htmlspecialchars($estado); ?></p>
<p><b>Autenticidad:</b> <?php echo htmlspecialchars($autenticidad); ?>%</p>
<p><b>Rareza:</b> <?php echo htmlspecialchars($rareza); ?></p>
<p><b>Precio sugerido:</b> <?php echo htmlspecialchars($precio); ?></p>
<p><b>Riesgo de réplica:</b> <?php echo htmlspecialchars($riesgo); ?></p>
<p style="color:#00A86B;"><b>Confianza IA:</b> 96%</p>

</div>

<a href="subir.php" class="btn secondary">Volver</a>

<a href="home.php" class="btn primary">Usar precio sugerido</a>

<div class="bottom-nav">
<a href="home.php">Inicio</a>
<a href="subir.php">Subir</a>
<a href="ofertas.php">Ofertas</a>
<a href="perfil.php">Perfil</a>
</div>

</div>

</body>
</html>