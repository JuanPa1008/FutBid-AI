<?php
session_start();

include "../config/conexion.php";

$usuario_id = isset($_SESSION['id']) ? $_SESSION['id'] : 1;

$equipo = $_POST['equipo'];
$jugador = $_POST['jugador'];
$temporada = $_POST['temporada'];
$talla = $_POST['talla'];
$precio = $_POST['precio_inicial'];
$duracion=$_POST['duracion'];

$fecha_cierre=
date(
"Y-m-d H:i:s",
strtotime("+$duracion minutes")
);

$imagen = "";

/* Subir imagen */

if(isset($_FILES['imagen']) && $_FILES['imagen']['error']==0){

    $nombreImagen=time()."_".$_FILES['imagen']['name'];

    $rutaDestino="../uploads/".$nombreImagen;

    move_uploaded_file(
        $_FILES['imagen']['tmp_name'],
        $rutaDestino
    );

    $imagen="uploads/".$nombreImagen;

}else{

    $imagen="img/playera.png";

}


/* Guardar playera */

$sql="INSERT INTO playeras
(
usuario_id,
equipo,
jugador,
temporada,
talla,
precio_inicial,
imagen,
fecha_cierre
)

VALUES
(
'$usuario_id',
'$equipo',
'$jugador',
'$temporada',
'$talla',
'$precio',
'$imagen',
'$fecha_cierre'
);


if(mysqli_query($conexion,$sql)){

echo "<script>

alert('Subasta publicada correctamente');

window.location.href='../home.php';

</script>";

}else{

echo "<script>

alert('Error al publicar');

window.location.href='../subir.php';

</script>";

}

?>