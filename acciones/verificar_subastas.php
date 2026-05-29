<?php

include __DIR__ . "/../config/conexion.php";
include __DIR__ . "/enviar_correo.php";

$subastas = mysqli_query($conexion,"
SELECT *
FROM playeras
WHERE finalizada=0
AND fecha_cierre<=NOW()
");

while($subasta=mysqli_fetch_assoc($subastas)){

    $playera_id=$subasta['id'];

    $ofertaMayor=mysqli_query($conexion,"
    SELECT 
    o.usuario_id,
    o.monto,
    u.nombre,
    u.correo
    FROM ofertas o
    INNER JOIN usuarios u
    ON o.usuario_id=u.id
    WHERE o.playera_id='$playera_id'
    ORDER BY o.monto DESC
    LIMIT 1
    ");

    if(mysqli_num_rows($ofertaMayor)>0){

        $ganador=mysqli_fetch_assoc($ofertaMayor);

        $ganador_id=$ganador['usuario_id'];
        $monto=$ganador['monto'];

        mysqli_query($conexion,"
        UPDATE playeras
        SET 
        ganador_id='$ganador_id',
        finalizada=1
        WHERE id='$playera_id'
        ");

        $nombreGanador=$ganador['nombre'];
        $correoGanador=$ganador['correo'];
        $playera=$subasta['equipo']." ".$subasta['temporada'];

        enviarCorreoGanador(
            $correoGanador,
            $nombreGanador,
            $playera,
            $monto
        );

    }else{

        mysqli_query($conexion,"
        UPDATE playeras
        SET finalizada=1
        WHERE id='$playera_id'
        ");

    }
}
?>