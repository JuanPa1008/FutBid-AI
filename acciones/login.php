<?php
session_start();

include "../config/conexion.php";

$correo = $_POST['correo'];
$password = $_POST['password'];

$sql = "SELECT * FROM usuarios 
        WHERE correo='$correo'";

$resultado = mysqli_query($conexion,$sql);

if(mysqli_num_rows($resultado)>0){

    $usuario=mysqli_fetch_assoc($resultado);

    if(password_verify(
        $password,
        $usuario['password']
    )){

        $_SESSION['id']=$usuario['id'];

        $_SESSION['nombre']=$usuario['nombre'];

        $_SESSION['correo']=$usuario['correo'];

        $_SESSION['rol']=$usuario['rol'];

        header("Location:../home.php");

    }else{

        echo "<script>

        alert('Contraseña incorrecta');

        window.location='../login.php';

        </script>";

    }

}else{

echo "<script>

alert('Usuario no encontrado');

window.location='../login.php';

</script>";

}
?>