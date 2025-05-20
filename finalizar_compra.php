<?php
session_start();

// Verificamos que haya productos en el carrito
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    header("Location: carrito.php");
    exit;
}

// Guardamos la compra actual en una sesión de historial 
if (!isset($_SESSION['historial_compras'])) {
    $_SESSION['historial_compras'] = [];
}

$compra_actual = [
    'usuario' => $_SESSION['usuario'] ?? 'invitado',
    'productos' => $_SESSION['carrito'],
    'fecha' => date('Y-m-d H:i:s')
];

// Añadir al historial
$_SESSION['historial_compras'][] = $compra_actual;

// Guardamos resumen en sesión temporal para mostrarlo
$_SESSION['ultima_compra'] = $compra_actual;

// Limpiamos carrito
$_SESSION['carrito'] = [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Compra finalizada</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="alert alert-success text-center">
    <h4 class="alert-heading">¡Gracias por tu compra, <?= htmlspecialchars($compra_actual['usuario']) ?>!</h4>
    <p>Tu pedido ha sido procesado correctamente el <strong><?= $compra_actual['fecha'] ?></strong>.</p>
  </div>

  <h5>Resumen de tu compra:</h5>
  <table class="table table-bordered mt-3">
    <thead class="table-dark">
      <tr>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Precio unitario</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $total = 0;
      foreach ($compra_actual['productos'] as $p):
          $subtotal = $p['precio'] * $p['cantidad'];
          $total += $subtotal;
      ?>
      <tr>
        <td><?= htmlspecialchars($p['nombre']) ?></td>
        <td><?= $p['cantidad'] ?></td>
        <td><?= number_format($p['precio'], 2) ?> €</td>
        <td><?= number_format($subtotal, 2) ?> €</td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <div class="text-end">
    <h5>Total pagado: <strong><?= number_format($total, 2) ?> €</strong></h5>
    <a href="tienda.php" class="btn btn-primary mt-3">Volver a la tienda</a>
  </div>
</div>

</body>
</html>
