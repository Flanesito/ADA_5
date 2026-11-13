<?php 
// Inclusion de Codigo Interpretado
require_once "datos.php";

// Control de acceso por sesion y redireccion HTTP
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

// Calculamos el resumen actual para mostrar el contador en el menu y boton flotante
$resumenHeader = calcularResumenCarrito($_SESSION["carrito"], $catalogo);
?>
<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Boutique & Music | Tineda Online</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="Estilos/estilos.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <body class="d-flex flex-column min-vh-100 bg-light">

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold" href="index.php">Boutique & Music</a>
                <div class="d-flex align-items-center gap-3">
                    <!-- Mostrar al Usuario Usando Sesiones -->
                    <span class="text-light small"> Hola, <strong><?php echo $_SESSION["usuario"]; ?></strong> </span>
                    <a href="carrito.php" class="btn btn-warning btn-sm fw-bold">  
                       🛒 Carrito <span class="badge bg-dark"> <?php echo $resumenHeader["totalUnidades"]; ?> </span>
                    </a>
                    <a href="login.php?logout=1" class="btn btn-outline-light btn-sm">Salir</a>
                </div>
            </div>
        </nav>

        <!-- Acceso rapido flotante al carrito -->
        <a href="carrito.php" class="btn-carrito-flotante shadow-lg">
            🛒 <span class="badge bg-danger rounded-pill"> <?php echo $resumenHeader["totalUnidades"]; ?> </span>
        </a>