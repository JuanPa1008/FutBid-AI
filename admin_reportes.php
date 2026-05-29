<?php
session_start();

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit();
}

if($_SESSION['rol'] != "admin"){
    header("Location: home.php");
    exit();
}

include "config/conexion.php";
include "acciones/verificar_subastas.php";

$total_usuarios = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM usuarios"));

$total_playeras = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM playeras"));

$total_ofertas = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM ofertas"));

$total_activas = mysqli_num_rows(mysqli_query($conexion, "
    SELECT *
    FROM playeras
    WHERE finalizada = 0
    AND fecha_cierre > NOW()
"));

$total_finalizadas = mysqli_num_rows(mysqli_query($conexion, "
    SELECT *
    FROM playeras
    WHERE finalizada = 1
"));

$total_vendido_query = mysqli_query($conexion, "
    SELECT SUM(max_oferta) AS total_vendido
    FROM (
        SELECT MAX(monto) AS max_oferta
        FROM ofertas
        GROUP BY playera_id
    ) AS ventas
");

$total_vendido_data = mysqli_fetch_assoc($total_vendido_query);
$total_vendido = $total_vendido_data['total_vendido'] ?? 0;

$oferta_mayor_query = mysqli_query($conexion, "
    SELECT MAX(monto) AS oferta_mayor
    FROM ofertas
");

$oferta_mayor_data = mysqli_fetch_assoc($oferta_mayor_query);
$oferta_mayor = $oferta_mayor_data['oferta_mayor'] ?? 0;

$usuario_mas_ofertas_query = mysqli_query($conexion, "
    SELECT u.nombre, COUNT(o.id) AS total
    FROM ofertas o
    INNER JOIN usuarios u ON o.usuario_id = u.id
    GROUP BY u.id
    ORDER BY total DESC
    LIMIT 1
");

$usuario_mas_ofertas = mysqli_fetch_assoc($usuario_mas_ofertas_query);

$usuario_mas_publicaciones_query = mysqli_query($conexion, "
    SELECT u.nombre, COUNT(p.id) AS total
    FROM playeras p
    INNER JOIN usuarios u ON p.usuario_id = u.id
    GROUP BY u.id
    ORDER BY total DESC
    LIMIT 1
");

$usuario_mas_publicaciones = mysqli_fetch_assoc($usuario_mas_publicaciones_query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reportes generales</title>
<link rel="stylesheet" href="css/styles.css">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

<div class="app-container">

<img src="img/logo.png" class="logo">

<h1>Reportes generales</h1>

<div class="card">
    <h3>📊 Resumen general</h3>
    <p>Usuarios registrados: <?php echo $total_usuarios; ?></p>
    <p>Playeras publicadas: <?php echo $total_playeras; ?></p>
    <p>Ofertas realizadas: <?php echo $total_ofertas; ?></p>
    <p>Subastas activas: <?php echo $total_activas; ?></p>
    <p>Subastas finalizadas: <?php echo $total_finalizadas; ?></p>
</div>

<div class="card">
    <h3>💰 Ventas y ofertas</h3>
    <p>Total vendido estimado: $<?php echo number_format($total_vendido,2); ?> MXN</p>
    <p>Oferta más alta: $<?php echo number_format($oferta_mayor,2); ?> MXN</p>
</div>

<div class="card">
    <h3>🏆 Usuario con más ofertas</h3>
    <?php if($usuario_mas_ofertas){ ?>
        <p><?php echo $usuario_mas_ofertas['nombre']; ?></p>
        <p>Total de ofertas: <?php echo $usuario_mas_ofertas['total']; ?></p>
    <?php }else{ ?>
        <p>No hay ofertas registradas.</p>
    <?php } ?>
</div>

<div class="card">
    <h3>📦 Usuario con más publicaciones</h3>
    <?php if($usuario_mas_publicaciones){ ?>
        <p><?php echo $usuario_mas_publicaciones['nombre']; ?></p>
        <p>Total de publicaciones: <?php echo $usuario_mas_publicaciones['total']; ?></p>
    <?php }else{ ?>
        <p>No hay publicaciones registradas.</p>
    <?php } ?>
</div>

<div class="card">
    <h3>📈 Gráfica general</h3>
    <canvas id="graficaGeneral"></canvas>
</div>

<a href="administrador.php" class="btn primary">Volver</a>

<div class="bottom-nav">
    <a href="home.php">Inicio</a>
    <a href="subir.php">Subir</a>
    <a href="ofertas.php">Ofertas</a>
    <a href="perfil.php">Perfil</a>
</div>

</div>

<script>
const ctx = document.getElementById('graficaGeneral');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
            'Usuarios',
            'Playeras',
            'Ofertas',
            'Activas',
            'Finalizadas'
        ],
        datasets: [{
            label: 'Estadísticas generales',
            data: [
                <?php echo $total_usuarios; ?>,
                <?php echo $total_playeras; ?>,
                <?php echo $total_ofertas; ?>,
                <?php echo $total_activas; ?>,
                <?php echo $total_finalizadas; ?>
            ],
            backgroundColor: [
                '#00F5A0',
                '#38BDF8',
                '#FACC15',
                '#22C55E',
                '#EF4444'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                labels: {
                    color: '#111827'
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    color: '#111827',
                    stepSize: 1
                }
            },
            x: {
                ticks: {
                    color: '#111827'
                }
            }
        }
    }
});
</script>

</body>
</html>