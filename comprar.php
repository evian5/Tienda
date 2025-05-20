<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['referencia'])) {
    $referencia = $_POST['referencia'];

    // con esto Insertamos la compra
    $sql = "INSERT INTO compras (referencia_producto) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $referencia);

    if ($stmt->execute()) {
        echo "Compra realizada con éxito.<br>";
    } else {
        echo "Error al realizar la compra: " . $conn->error;
    }

    $stmt->close();
    $conn->close();

    echo "<a href='tienda.php'>Volver a la tienda</a>";
} else {
    echo "Datos no válidos.";
}
?>
