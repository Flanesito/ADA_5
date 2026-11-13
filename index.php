<?php 
require_once "datos.php";

// Recibir producto POST y guardarlo en la sesion del carrito
$alertaProducto = "";
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id_producto"])) {
    $id = (int)$_POST["id_producto"];
    if = (isset($catalogo[$id])) {
        $_SESSION["carrito"][$id] = ($_SESSION["carrito"][$id] ?? 0) + 1;
        $alertaProducto = $catalogo[$id]->nombre;
    }
}

// Incluimos la barra de navegacion
require_once "header.php"
?>
