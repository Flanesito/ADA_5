<?php 
require_once "datos.php";

// Modificar o eliminar productos de la sesion antes del header
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["accion"])) {
    $id = (int)($_POST["id_producto"] ?? 0);

    if ($_POST["accion"] === "actualizar" && isset($_POST["cantidad"])) {
        $nuevaCant = (int)$_POST["cantidad"];
        if ($nuevaCant > 0) {
            $_SESSION["carrito"][$id] = $nuevaCant; // Modificar cantidad
        } else {
            unset($_SESSION["carrito"][$id]); // Si pone 0, se elimina
        }
    } elseif ($_POST["accion"] === "eliminar") {
        unset($_SESSION["carrito"][$id]); // Eliminar producto
    } elseif ($_POST["accion"] === "vaciar") {
        $_SESSION["carrito"] = []; // Vaciar todo el carrito
    }
}

require_once "header.php";
$resumen = calcularResumenCarrito($_SESSION["carrito"], $catalogo);
?>

<main class="container my-4 flex-grow-1">
    <h2 class="fw-bold mb-4">🛒 Tu Carrito de Compras</h2>

    <?php if (empty($_SESSION["carrito"])): ?>
        <div class="alert alert-secondary text-center p-5 rounded-4">
            <h4>Tu carrito está vacío</h4>
            <a href="index.php" class="btn btn-dark mt-3">Explorar productos 🛍️</a>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <!-- Lista de productos (Izquierda) -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-4 p-3">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION["carrito"] as $id => $cant): 
                                $prod = $catalogo[$id];
                            ?>
                            <tr>
                                <td><strong><?php echo $prod->nombre; ?></strong></td>
                                <td>$<?php echo number_format($prod->precio, 2); ?></td>
                                <td style="max-width: 130px;">
                                    <!-- Modificar cantidad -->
                                    <form method="POST" action="carrito.php" class="d-flex gap-1">
                                        <input type="hidden" name="accion" value="actualizar">
                                        <input type="hidden" name="id_producto" value="<?php echo $id; ?>">
                                        <input type="number" name="cantidad" value="<?php echo $cant; ?>" min="1" class="form-control form-control-sm">
                                        <button type="submit" class="btn btn-sm btn-outline-dark">↻</button>
                                    </form>
                                </td>
                                <td class="fw-bold">$<?php echo number_format($prod->precio * $cant, 2); ?></td>
                                <td>
                                    <!-- Eliminar producto -->
                                    <form method="POST" action="carrito.php">
                                        <input type="hidden" name="accion" value="eliminar">
                                        <input type="hidden" name="id_producto" value="<?php echo $id; ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">🗑️</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-between mt-2">
                        <a href="index.php" class="btn btn-outline-secondary btn-sm">← Seguir comprando</a>
                        <form method="POST" action="carrito.php">
                            <input type="hidden" name="accion" value="vaciar">
                            <button type="submit" class="btn btn-outline-danger btn-sm">Vaciar carrito</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Resumen estilo Amazon (Derecha/Inferior) -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
                    <h5 class="fw-bold border-bottom pb-2">Resumen del Pedido</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Productos (<?php echo $resumen["totalUnidades"]; ?>):</span>
                        <span>$<?php echo number_format($resumen["subtotal"], 2); ?> MXN</span>
                    </div>

                    <?php if ($resumen["porcentajeDescuento"] > 0): ?>
                    <div class="d-flex justify-content-between mb-2 text-success fw-semibold">
                        <span>Cupón aplicado (<?php echo $resumen["porcentajeDescuento"]; ?>% DTO.):</span>
                        <span>-$<?php echo number_format($resumen["montoDescuento"], 2); ?> MXN</span>
                    </div>
                    <?php endif; ?>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Envío:</span>
                        <span>
                            <?php echo ($resumen["costoEnvio"] == 0) ? '<strong class="text-success">GRATIS</strong>' : '$100.00 MXN'; ?>
                        </span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fs-5 fw-bold text-dark mb-3">
                        <span>Total a pagar:</span>
                        <span>$<?php echo number_format($resumen["totalFinal"], 2); ?> MXN</span>
                    </div>

                    <button id="btn-pagar" class="btn btn-warning w-100 fw-bold btn-lg">Proceder al pago 💳</button>
                </div>
            </div>
        </div>
    <?php endif; ?>
</main>

<script>
const btnPagar = document.querySelector("#btn-pagar");
if (btnPagar) {
    btnPagar.addEventListener("click", () => {
        Swal.fire({
            icon: "info",
            title: "Aviso de Compra",
            html: `Aún no contamos con una conexión con algún banco autorizado, ni con la página en un servidor en internet.<br><br>
                   <small class="text-muted"><em>La página web es solo un prototipo y no tiene aún ningún impacto en la web al interactuar.</em></small>`,
            confirmButtonText: "Entendido",
            confirmButtonColor: "#212529"
        });
    });
}
</script>
</body>
</html>