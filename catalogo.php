<?php
header("Content-type: text/xml");
header("Content-Disposition: attachment; filename=catalogo.xml");

include 'conexion.php';

$sql = "SELECT referencia, nombre, precio FROM productos";
$resultado = $conn->query($sql);

$xml = new DOMDocument("1.0", "UTF-8");
$xml->formatOutput = true;

$root = $xml->createElement("catalogo");

while ($row = $resultado->fetch_assoc()) {
    $producto = $xml->createElement("producto");

    $referencia = $xml->createElement("referencia", $row['referencia']);
    $nombre = $xml->createElement("nombre", $row['nombre']);
    $precio = $xml->createElement("precio", $row['precio']);

    $producto->appendChild($referencia);
    $producto->appendChild($nombre);
    $producto->appendChild($precio);

    $root->appendChild($producto);
}

$xml->appendChild($root);
echo $xml->saveXML();

$conn->close();
?>

<a href="catalogo.php"><button> Descargar Catálogo XML</button></a> 
