<?php
session_start();

// Inicializar el carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Eliminar un producto individual
if (isset($_GET['eliminar'])) {
    $refEliminar = $_GET['eliminar'];
    foreach ($_SESSION['carrito'] as $index => $producto) {
        if ($producto['referencia'] === $refEliminar) {
            unset($_SESSION['carrito'][$index]);
            $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexar
            break;
        }
    }
}

// Vaciar todo el carrito
if (isset($_GET['vaciar'])) {
    $_SESSION['carrito'] = [];
}

$total = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Carrito de Compras</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h2 class="mb-4 text-center">🛒 Tu carrito</h2>

  <div class="mb-3 text-end">
    <a href="tienda.php" class="btn btn-secondary">← Seguir comprando</a>
    <a href="carrito.php?vaciar=1" class="btn btn-danger">Vaciar carrito</a>
  </div>

  <?php if (empty($_SESSION['carrito'])): ?>
    <div class="alert alert-info text-center">
      Tu carrito está vacío.
    </div>
  <?php else: ?>
    <table class="table table-bordered table-hover">
      <thead class="table-dark">
        <tr>
          <th>Producto</th>
          <th>Referencia</th>
          <th>Precio</th>
          <th>Cantidad</th>
          <th>Total</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($_SESSION['carrito'] as $item): 
          $subtotal = $item['precio'] * $item['cantidad'];
          $total += $subtotal;
        ?>
          <tr>
            <td><?= htmlspecialchars($item['nombre']) ?></td>
            <td><?= htmlspecialchars($item['referencia']) ?></td>
            <td><?= number_format($item['precio'], 2) ?> €</td>
            <td><?= $item['cantidad'] ?></td>
            <td><?= number_format($subtotal, 2) ?> €</td>
            <td>
              <a href="carrito.php?eliminar=<?= urlencode($item['referencia']) ?>" class="btn btn-sm btn-outline-danger">Eliminar</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div class="text-end">
      <h4>Total: <strong><?= number_format($total, 2) ?> €</strong></h4>
      <a href="finalizar_compra.php" class="btn btn-success mt-3">Finalizar compra</a>
    </div>
  <?php endif; ?>
</div>

</body>
</html>
