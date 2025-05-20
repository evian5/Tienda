<?php
session_start();

// Verificar que llegan todos los datos ( pablo aprubame)
if (!isset($_POST['referencia'], $_POST['nombre'], $_POST['precio'], $_POST['cantidad'])) {
    echo "Error: Datos incompletos";
    exit;
}

// Recoger datos del formulario
$referencia = $_POST['referencia'];
$nombre = $_POST['nombre'];
$precio = floatval($_POST['precio']);
$cantidad = intval($_POST['cantidad']);

if ($cantidad <= 0) {
    $cantidad = 1;
}

// Crear el producto para añadir
$producto = [
    'referencia' => $referencia,
    'nombre' => $nombre,
    'precio' => $precio,
    'cantidad' => $cantidad
];

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Si ya existe ese producto, se suma la cantidad
$encontrado = false;
foreach ($_SESSION['carrito'] as &$item) {
    if ($item['referencia'] === $referencia) {
        $item['cantidad'] += $cantidad;
        $encontrado = true;
        break;
    }
}
unset($item); 

// Si no está, lo añadimos
if (!$encontrado) {
    $_SESSION['carrito'][] = $producto;
}

header("Location: carrito.php");
exit;
