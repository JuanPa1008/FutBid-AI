<?php
session_start();

include "../config/conexion.php";

$usuario_id = isset($_SESSION['id']) ? $_SESSION['id'] : 1;
$playera_id = $_POST['playera_id'];
$monto = $_POST['monto'];

if($playera_id == 0 || empty($playera_id)){
    echo "<script>
        alert('Primero debes seleccionar una playera registrada en la base de datos.');
        window.location.href='../home.php';
    </script>";
    exit();
}

$verificar = "SELECT * FROM playeras WHERE id = '$playera_id'";
$resultado = mysqli_query($conexion, $verificar);

if(mysqli_num_rows($resultado) == 0){
    echo "<script>
        alert('La playera seleccionada no existe en la base de datos.');
        window.location.href='../home.php';
    </script>";
    exit();
}

$sql = "INSERT INTO ofertas (usuario_id, playera_id, monto)
        VALUES ('$usuario_id', '$playera_id', '$monto')";

if(mysqli_query($conexion, $sql)){
    echo "<script>
        alert('Oferta registrada correctamente');
        window.location.href='../ofertas.php';
    </script>";
}else{
    echo "<script>
        alert('Error al registrar la oferta');
        window.location.href='../home.php';
    </script>";
}
?>