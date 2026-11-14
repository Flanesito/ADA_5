<?php 
require_once "datos.php";

// Recibir producto POST y guardarlo en la sesion del carrito
$alertaProducto = "";
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id_producto"])) {
    $id = (int)$_POST["id_producto"];
    if (isset($catalogo[$id])) {
        $_SESSION["carrito"][$id] = ($_SESSION["carrito"][$id] ?? 0) + 1;
        $alertaProducto = $catalogo[$id]->nombre;
    }
}

// Incluimos la barra de navegacion
require_once "header.php"
?>
<main class="container my-4 flex-grow-1">

    <!-- Banner de promociones y acceso rapido al carrito -->
    <div class="p-4 mb-4 bg-dark text-white rounded-4 shadow-sm d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1 class="h3 fw-bold mb-1">✨ Catálogo Exclusivo</h1>
            <p class="mb-0 text-warning small">🎁 Más de 5 productos: <strong>20% DTO.</strong> | Más de 10 productos: <strong>30% DTO.</strong> | Envío GRATIS desde $300 MXN</p>
        </div>
        <a href="carrito.php" class="btn btn-outline-warning fw-bold">Ver mi carrito ahora →</a>
    </div>

    <!-- Cuadricula de productos (ciclo foreach) -->
    <div class="row g-4">
        <?php foreach ($catalogo as $prod): ?>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card tarjeta-producto shadow-sm h-100">
                <!-- Mitad superior: imagen -->
                <div class="contenedor-img"> 
                    <img src="<?php echo $prod->imagen; ?>" alt="<?php echo $prod->nombre; ?>" onerror="this.src='https://placehold.co/400x300?text=Foto+Pendiente'">
                </div>
                <!-- Mitad inferior: Nombre, precio e info extra al acercar el cursor -->
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <span class="badge bg-secondary mb-1"> <?php echo $prod->categoria; ?> </span>
                        <h5 class="card-title fw-bold mb-1"> <?php echo $prod->nombre; ?> </h5>
                        <p class="text-succes fw-bold fs-5 mb-0"> <?php echo number_format($prod->precio, 2); ?> MXN</p>

                        <div class="info-extra">
                            <p class="text-muted small-mb-2"> <?php echo $prod->detalleExtra; ?> </p>
                        </div>
                    </div>

                    <form method="POST" action="index.php" class="mt-2">
                        <input type="hidden" name="id_producto" value="<?php echo $prod->id; ?>">
                        <button type="submit" class="btn btn-dark w-100 fw-semibold">+ Agregar al carrito</button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</main>

<?php if ($alertaProducto !== ""): ?>
<script> 
    Swal.fire({
        icon: "succes",
        title: "¡Agregado al carrito!",
        text: "<?php echo $alertaProducto; ?> se sumó a tu pedido.",
        showCancelButton: true,
        confirmButtonText: "Ir al carrito 🛒",
        canlceButtonText: "Seguir comprando",
        confirmButtonColor: "#ffc107"
    }).then((result) => {
        if (result.isConfirmed) { window.location.href = "carrito.php"; }
    });
</script>
<?php endif; ?>
</body>
</html>
