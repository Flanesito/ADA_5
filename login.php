<?php 
// Inclusion de Codigo Interpretado (traemos la sesion de datos.php)
require_once "datos.php";

// Opcion para cerrar sesion (Intercambio por GET y Sesiones)
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php"); // Headers HTTP
    exit;
}

// Intercambio de infromacion entre paginas (Recepcion por POST)
$error = false;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Buenas Practicas - Limpieza y control de datos de entrada
    $nombreUsuario = trim(htmlspecialchars($_POST["usuario"] ?? ""));

    if (!empty($nombreUsuario)) {
        // Manejo de Sesiones - Guardamos al cliente
        $_SESSION["usuario"] = $nombreUsuario;

        // Base de datos para guardar los datos de inicio de sesion
        $conn = new mysqli("localhost", "root", "", "mysql");
        $stmt = $conn->prepare("INSERT INTO accesos_tienda (usuario) VALUES (?)");
        $stmt->bind_param("s", $nombreUsuario);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        // Headers HTTP - Redireccion hacia la tienda
        header("Location: index.php?bienvenida=1");
        exit;
    } else {
        $error = true;
    }
}
?>

<!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Iniciar Sesión | Boutique & Music</title>
        <!-- Bootstrap 5 y SweetAlert2 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <body class="bg-light d-flex align-items-center justify-content-center vh-100">

        <div class="card shadow-lg border-0 p-4" style="max-width: 420px; width: 100%; border-radius: 16px;">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-dark">✨ Bienvenido</h2>
                <p class="text-muted small">Ingresa tu nombre para personalizar tu carrito de compras</p>
            </div>

            <form id="form-login" method="POST" action="login.php">
                <div class="mb-3">
                    <label for="usuario" class="form-label fw-semibold">Nombre de cliente:</label>
                    <input type="text" id="usuario" name="usuario" class="form-control form-control-lg" placeholder="Nombre/s - Apellido Paterno - Apellido Materno">
                </div>
                <button type="submit" class="btn btn-dark w-10 btn-lg mt-2">Entrar a la Tienda 🛍️</button>
            </form>
        </div>

        <script>
            // Validacion en el cliente con SweetAlert2
            document.querySelector("#form-login").addEventListener("submit", funcion(e)) {
                const input = document.querySelector("#usuario").value.trim();
                if (input === "") {
                    e.preventDefault();
                    Swal.fire({
                        icon: "warning",
                        title: "Nombre requerido",
                        text: "Por favor escribe tu nombre para iniciar tu sesión de compra.",
                        confirmButtonColor: "#212529"
                    });
                }
            }
        </script>
    </body>
</html>