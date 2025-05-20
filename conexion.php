<?php
$servername = "localhost";  
$username = "root";        
$password = "";            
$dbname = "tienda_virtual"; 

// Creamos  la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificamos  la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
echo "Conexión exitosa.";
?>
