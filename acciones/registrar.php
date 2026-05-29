<?php
include "../config/conexion.php";

$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$password = $_POST['password'];
$confirmar = $_POST['confirmar'];

if ($password !== $confirmar) {
    echo "<script>
    alert('Las contraseñas no coinciden');
    window.location.href='../registro.php';
    </script>";
    exit;
}

$password_segura = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (nombre, correo, password) 
        VALUES ('$nombre', '$correo', '$password_segura')";

if (mysqli_query($conexion, $sql)) {
    echo "<script>
    alert('Usuario registrado correctamente');
    window.location.href='../login.php';
    </script>";
} else {
    echo "<script>
    alert('Error al registrar usuario');
    window.location.href='../registro.php';
    </script>";
}
?>