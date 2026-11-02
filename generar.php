<?php
session_start();

$productos = [
    1 => [
        "nombre" => "Cuaderno 100 hojas",
        "precio" => 8500,
        "imagen" => "imagenes/cuaderno.png"
    ],
    2 => [
        "nombre" => "Lapicero negro",
        "precio" => 2000,
        "imagen" => "imagenes/lapicero.png"
    ],
    3 => [
        "nombre" => "Resma de papel",
        "precio" => 18000,
        "imagen" => "imagenes/resma.png"
    ],
    4 => [
        "nombre" => "Caja de colores",
        "precio" => 12000,
        "imagen" => "imagenes/colores.png"
    ],
    5 => [
        "nombre" => "Borrador",
        "precio" => 1500,
        "imagen" => "imagenes/borrador.png"
    ],
    6 => [
        "nombre" => "Regla de 30 cm",
        "precio" => 2500,
        "imagen" => "imagenes/regla.png"
    ],
    7 => [
        "nombre" => "Sacapuntas",
        "precio" => 1800,
        "imagen" => "imagenes/sacapuntas.png"
    ],
    8 => [
        "nombre" => "Marcadores x12",
        "precio" => 9500,
        "imagen" => "imagenes/marcadores.png"
    ],
    9 => [
        "nombre" => "Pegante en barra",
        "precio" => 3500,
        "imagen" => "imagenes/pegante.png"
    ],
    10 => [
        "nombre" => "Cartulina",
        "precio" => 1800,
        "imagen" => "imagenes/cartulina.png"
    ],
    11 => [
        "nombre" => "Carpeta legajadora",
        "precio" => 4000,
        "imagen" => "imagenes/carpeta.png"
    ],
    12 => [
        "nombre" => "Tijeras escolares",
        "precio" => 5500,
        "imagen" => "imagenes/tijeras.png"
    ]
];
$carrito = $_SESSION['carrito'] ?? [];

if (empty($carrito)) {
    echo "El carrito está vacío. Regresa y agrega productos.";
    exit;
}

$total = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pedido confirmado - Papelería San Carlos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f4f8;
            padding: 30px;
        }
        .contenedor {
            max-width: 850px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
        }
        h1 { color: #0866c6; text-align: center; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: center; }
        th { background: #0866c6; color: white; }
        .total { text-align: right; font-size: 22px; font-weight: bold; }
        a {
            display: inline-block;
            background: #0866c6;
            color: white;
            padding: 12px 18px;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="contenedor">
    <h1>¡Pedido confirmado!</h1>
    <p>Gracias por comprar en Papelería San Carlos.</p>
    <p><strong>Fecha:</strong> <?= date("d/m/Y H:i") ?></p>

    <h2>Detalle del pedido</h2>

    <table>
        <tr>
            <th>Producto</th>
            <th>Precio unitario</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
        </tr>

        <?php foreach ($carrito as $id => $cantidad): ?>
            <?php if (isset($productos[$id]) && $cantidad > 0): ?>
                <?php
                    $nombre = $productos[$id]['nombre'];
                    $precio = $productos[$id]['precio'];
                    $subtotal = $precio * $cantidad;
                    $total += $subtotal;
                ?>
                <tr>
                    <td><?= htmlspecialchars($nombre) ?></td>
                    <td>$<?= number_format($precio, 0, ',', '.') ?></td>
                    <td><?= (int)$cantidad ?></td>
                    <td>$<?= number_format($subtotal, 0, ',', '.') ?></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php
unset($_SESSION['carrito']);
?>
    </table>

    <p class="total">
        Total a pagar: $<?= number_format($total, 0, ',', '.') ?>
    </p>

    <p style="text-align:center;">
        <a href="carrito.php">Volver a la tienda</a>
    </p>
</div>

</body>
</html>