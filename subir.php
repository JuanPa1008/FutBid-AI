<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Subir Playera</title>

<link rel="stylesheet" href="css/styles.css">
</head>

<body>

<div class="app-container">

    <img src="img/logo.png" class="logo" alt="Logo FutBid AI">

    <h1>Subir playera</h1>

    <!-- Vista previa dinámica -->
   <img
src=""
class="jersey-preview"
id="previewPlayera"
alt="Vista previa"
style="display:none;">

    <p>Vista previa</p>

    <form action="acciones/publicar.php" method="POST" enctype="multipart/form-data">

        <input 
            class="input" 
            type="file" 
            name="imagen" 
            id="imagen" 
            accept="image/*" 
            onchange="mostrarVistaPrevia(event)"
        >

        <input 
            class="input" 
            name="equipo" 
            placeholder="Equipo" 
            required
        >

        <input 
            class="input" 
            name="jugador" 
            placeholder="Jugador"
        >

        <input 
            class="input" 
            name="temporada" 
            placeholder="Temporada"
        >

        <input 
            class="input" 
            name="talla" 
            placeholder="Talla"
        >

        <input 
            class="input" 
            name="precio_inicial" 
            type="number" 
            placeholder="Precio inicial" 
            required
        > 
<input
class="input"
name="duracion"
type="number"
placeholder="Duración (minutos)"
required>

        <button 
            type="button" 
            onclick="analizarPlayera()" 
            class="btn primary"
        >
            Analizar con IA
        </button>

        <button 
            type="submit" 
            class="btn secondary"
        >
            Publicar subasta
        </button>

    </form>

    <div class="bottom-nav">
        <a href="home.php">Inicio</a>
        <a href="subir.php">Subir</a>
        <a href="ofertas.php">Ofertas</a>
        <a href="perfil.php">Perfil</a>
    </div>

</div>

<script src="js/app.js"></script>

</body>
</html>