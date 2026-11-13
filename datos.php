<?php 
// Manejo de sesiones - Inicia o recupera la sesi[on activa del usuario
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Iniicalizamos el carrito en la sesion si aun no existe (Estructura de datos)
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = []; // Guardara: [id_producto => cantidad]
}

// Programacion Orientada a Ojetos (POO)
class Producto {
    public $id;
    public $nombre;
    public $categoria;
    public $precio;
    public $detalleExtra;
    public $imagen; // Guardara la ruta de la imagen del producto

    public function __construct($id, $nombre, $categoria, $precio, $detalleExtra, $imagen){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->categoria = $categoria;
        $this->precio = $precio;
        $this->detalleExtra = $detalleExtra;
        $this->imagen = $imagen;
    }
}

// Estructuras de Datos (Arreglo asociativo de objetos Procucto)
$catalogo = [
    1 => new Producto(1, "Lirios Rojos Imperiales (Edición Limitada)", "Flores", 580.00, "Variedad exotica de pétalos carmesí intenso; cultivados en invernadero especial.", "imgs/Lirios_Rojos.jpeg"),
    2 => new Producto(2, "Ramo de Lirios Blancos y Rosas", "Flores", 260.00, "Aroma fresco y duradero, ideal para regalo o decoración.", "imgs/Lirios_Blancos_Rosas.jpeg"),
    3 => new Producto(3, "Harry Styles - Harry's House (Vinilo)", "Música", 650.00, "¡El más vendido! Incluye póster exclusivo y éxitos como As It Was.", "imgs/Album_Harrys_House.jpeg"),
    4 => new Producto(4, "Harry Styles - Fine Line (Edición Especial)", "Música", 590.00, "Álbum doble con libreto de fotos inéditas de estudio.", "imgs/Fine_Line.jpeg"),
    5 => new Producto(5, "Peluche de Cerdito Rosado Suave", "Peluches", 220.00, "Relleno de hipoalergénico ultra esponjoso de 30 cm.", "imgs/peluche_cerdito.jpeg"),
    6 => new Producto(6, "Peluche de Monito Abrazable", "Peluches", 240.00, "Brazos largos con velcro en las manos para colgarlo.", "imgs/peluche_monito.jpg"),
    7 => new Producto(7, "Peluche de Gatito Glotón", "Peluches", 200.00, "Textura aterciopelada con detalles bordados a mano.", "imgs/peluche_gatito.jpg"),
    8 => new Producto(8, "Suéter Rosa Pastel", "Ropa",390.00, "Tejido suave de algodón, corte holgado y cómodo.", "imgs/sueter_rosa.jpg"),
    9 => new Producto(9, "Chamarra Casual Verde Olivo", "Ropa",480.00, "Tela impermeable ligera con bolsillos laterales.", "imgs/chamarra_verde.jpg"),
    10 => new Producto(10, "Conjunto Minimalista Café Otoño", "Ropa",440.00, "Tono tierra cálido que combina con cualquier estilo.", "imgs/conjunto_cafe.jpg"),
    11 => new Producto(11, "Set de Pestañas Magnéticas 3D", "Belleza",180.00, "Efecto volumen natural, reutilizables hasta 30 veces.", "imgs/pestanas.jpg"),
    12 => new Producto(12, "Kit Glow de Belleza e Hidratación", "Belleza",320.00, "Incluye sérum facial iluminador, gloss y bruma fijadora.", "imgs/kit_belleza.jpg")
];

// Variables, Operadores, Estructuras de Control y Funciones
function calcularResumenCarrito($carrito, $catalogo)
?>