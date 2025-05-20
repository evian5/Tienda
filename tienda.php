<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit;
}

include 'conexion.php';

$sql = "SELECT referencia, nombre, precio FROM productos";
$resultado = $conn->query($sql);

function getImageFile($nombre) {
    $imagenes = [
        "Haunting Adeline" => "../IMG/Haunting_Adeline_.jpg",
        "Crudence" => "crudence.jpg",
        "Antes de Diciembre " => "Antes.jpg",
        "Twisted Love" => "twisted_love.jpg",
        "Boulevard" => "boulevard.jpg",
        "The Cheat Sheet" => "cheat_sheet.jpg",
        "Little Stranger" => "Litle_Stranger.jpg",
        "Marfil y Ebano " => "marfil_y_ebano.jpg",
        "Corrupt" => "corrupt.jpg",
        "Etereo" => "etereo.jpg"
    ];

    $filename = $imagenes[$nombre] ?? "default.jpg";
    return "img/" . $filename;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Tienda Virtual</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <style>
    /* tu CSS personalizado aquí (igual que antes, no lo repito para no alargar) */
    /* incluye .fondo-oscuro, estilos de cards, botones, header, alerta, etc */
    body {
      background: linear-gradient(135deg, #f7f1e3, #dfe6e9);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #333;
      padding-top: 70px;
    }
    header {
      position: fixed;
      top: 0;
      width: 100%;
      background-color: #006633;
      color: white;
      padding: 10px 20px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
      z-index: 1030;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    header h1 {
      font-weight: bold;
      font-size: 1.5rem;
      margin: 0;
      user-select: none;
    }
    header nav a {
      color: white;
      margin-left: 20px;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s ease;
    }
    header nav a:hover {
      color: #a3d9a5;
    }
    .fondo-oscuro {
      background-color: rgba(255, 255, 255, 0.95);
      padding: 2rem;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .card {
      border: none;
      border-radius: 15px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      background-color: #ffffff;
      color: #000;
      box-shadow: 0 4px 8px rgb(0 0 0 / 0.1);
    }
    .card:hover {
      transform: translateY(-8px) scale(1.02);
      box-shadow: 0 10px 25px rgb(0 0 0 / 0.15);
    }
    .card-img-top {
      border-top-left-radius: 15px;
      border-top-right-radius: 15px;
      height: 300px;
      object-fit: cover;
      transition: transform 0.3s ease;
    }
    .card-img-top:hover {
      transform: scale(1.05);
    }
    .btn-success {
      background-color: #006633;
      border: none;
      font-weight: 600;
      box-shadow: 0 4px 8px rgb(0 102 51 / 0.3);
      transition: background-color 0.3s ease;
    }
    .btn-success:hover {
      background-color: #004d26;
    }
    .btn-danger {
      background-color: #cc0000;
      font-weight: 600;
      box-shadow: 0 4px 8px rgb(204 0 0 / 0.3);
      transition: background-color 0.3s ease;
    }
    .btn-danger:hover {
      background-color: #990000;
    }
    h2 {
      color: #2d3436;
      font-weight: bold;
      user-select: none;
    }
    label {
      font-weight: 500;
    }
    footer {
      margin-top: 3rem;
      padding: 1rem 0;
      text-align: center;
      font-size: 0.9rem;
      color: #555;
      user-select: none;
    }
    input[type="number"] {
      max-width: 80px;
      border-radius: 6px;
      border: 1px solid #ccc;
      padding: 5px 8px;
      font-size: 1rem;
      transition: border-color 0.3s ease;
    }
    input[type="number"]:focus {
      border-color: #006633;
      outline: none;
      box-shadow: 0 0 5px #006633aa;
    }
    #alerta {
      position: fixed;
      top: 80px;
      right: 20px;
      background-color: #28a745cc;
      color: white;
      padding: 10px 20px;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.2);
      font-weight: 600;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.4s ease;
      z-index: 2000;
      user-select: none;
    }
    #alerta.show {
      opacity: 1;
      pointer-events: auto;
    }
  </style>
</head>
<body>

<header>
  <h1>📚 Tienda Virtual</h1>
  <nav>
    <a href="tienda.php">Inicio</a>
    <a href="carrito.php"><i class="fas fa-shopping-cart"></i> Carrito</a>
    <a href="logout.php" class="btn btn-danger btn-sm px-3">Cerrar sesión</a>
  </nav>
</header>

<div class="container fondo-oscuro">
  <h2 class="mb-4 text-center">Bienvenido, <?= htmlspecialchars($_SESSION['usuario']) ?> 📚</h2>

  <div class="row">
    <?php while ($row = $resultado->fetch_assoc()) :
      $nombre = $row['nombre'];
      $img_url = getImageFile($nombre);
    ?>
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow">
          <img src="<?= $img_url ?>" class="card-img-top" alt="<?= htmlspecialchars($nombre) ?>" />
          <div class="card-body d-flex flex-column">
            <h5 class="card-title"><?= htmlspecialchars($nombre) ?></h5>
            <p class="card-text text-muted">Referencia: <?= htmlspecialchars($row['referencia']) ?></p>
            <p class="card-text fs-5"><strong><?= number_format($row['precio'], 2) ?> €</strong></p>

            <form action="añadir_carrito.php" method="post" class="mt-auto">
              <input type="hidden" name="referencia" value="<?= $row['referencia'] ?>" />
              <input type="hidden" name="nombre" value="<?= $row['nombre'] ?>" />
              <input type="hidden" name="precio" value="<?= $row['precio'] ?>" />
              <label for="cantidad-<?= $row['referencia'] ?>">Cantidad:</label>
              <input
                type="number"
                id="cantidad-<?= $row['referencia'] ?>"
                name="cantidad"
                value="1"
                min="1"
                class="form-control mb-2"
                required
                aria-label="Cantidad para <?= htmlspecialchars($nombre) ?>"
              />
              <button type="submit" class="btn btn-success w-100">
                <i class="fas fa-cart-plus"></i> Añadir al carrito
              </button>
            </form>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<div id="alerta">Producto añadido al carrito ✔️</div>

<footer>
  &copy; <?= date("Y") ?> Tienda Virtual. Todos los derechos reservados.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Muestra una  alerta 
  const params = new URLSearchParams(window.location.search);
  if (params.has('added')) {
    const alerta = document.getElementById('alerta');
    alerta.classList.add('show');
    setTimeout(() => alerta.classList.remove('show'), 2000);
    // Limpia la URL para evitar que la alerta salga siempre
    window.history.replaceState({}, document.title, window.location.pathname);
  }
</script>

</body>
</html>


<?php $conn->close(); ?>
