
<?php
session_start();

// Inicializar carrito
if (!isset($_SESSION["carrito"])) {
    $_SESSION["carrito"] = [];
}

// Actualizar cantidades
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $accion = $_POST["accion"] ?? "";

    if ($accion === "actualizar") {

        foreach ($_POST["cantidades"] ?? [] as $id => $cantidad) {

            $id = (int)$id;
            $cantidad = (int)$cantidad;

            if (isset($_SESSION["carrito"][$id])) {

                if ($cantidad <= 0) {
                    unset($_SESSION["carrito"][$id]);
                } else {
                    $_SESSION["carrito"][$id]["cantidad"] = min($cantidad, 99);
                }
            }
        }
    }

    // Eliminar producto
    if ($accion === "eliminar") {

        $id = (int)($_POST["id"] ?? 0);

        unset($_SESSION["carrito"][$id]);
    }

    // Vaciar carrito
    if ($accion === "vaciar") {
        $_SESSION["carrito"] = [];
    }

    header("Location: carrito.php");
    exit;
}

// Calcular total
$total = 0;
$unidades = 0;

foreach ($_SESSION["carrito"] as $producto) {

    $subtotal = $producto["precio"] * $producto["cantidad"];

    $total += $subtotal;
    $unidades += $producto["cantidad"];
}

// Formato de pesos colombianos
function pesos($valor) {
    return "$" . number_format($valor, 0, ",", ".");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Carrito de compras - Papelería San Carlos</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f3f6f9;
            margin: 0;
            color: #333;
        }

        header {
            background: #0866c6;
            color: white;
            text-align: center;
            padding: 25px;
        }

        .contenedor {
            width: 90%;
            max-width: 1100px;
            margin: 30px auto;
        }

        h2 {
            color: #0866c6;
        }

        .tabla {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-top: 20px;
        }

        .tabla th,
        .tabla td {
            padding: 15px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .tabla th {
            background: #0866c6;
            color: white;
        }

        input[type="number"] {
            width: 70px;
            padding: 8px;
        }

        button,
        .enlace {
            border: none;
            padding: 11px 17px;
            border-radius: 5px;
            cursor: pointer;
            background: #0866c6;
            color: white;
            text-decoration: none;
            display: inline-block;
        }

        button:hover,
        .enlace:hover {
            background: #064e96;
        }

        .eliminar {
            background: #dc3545;
        }

        .vaciar {
            background: #666;
        }

        .total {
            background: #e5f5e9;
            padding: 20px;
            text-align: right;
            font-size: 22px;
            font-weight: bold;
            margin-top: 20px;
            border-radius: 8px;
        }

        .acciones {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .mensaje {
            background: white;
            padding: 30px;
            text-align: center;
            border-radius: 8px;
        }

        footer {
            background: #0866c6;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
        }

        @media(max-width: 600px) {
            .tabla th,
            .tabla td {
                padding: 7px;
                font-size: 12px;
            }
        }
    </style>
</head>

<body>

<header>
    <h1>Papelería San Carlos</h1>
    <p>Carrito de compras</p>
</header>

<main class="contenedor">

    <h2>Mi carrito (<?= $unidades ?> unidades)</h2>

    <a href="catalogo.php" class="enlace">
        Seguir comprando
    </a>

    <?php if (empty($_SESSION["carrito"])): ?>

        <div class="mensaje">
            <h3>Tu carrito está vacío</h3>
            <p>Selecciona los productos que deseas comprar.</p>
        </div>

    <?php else: ?>

        <form method="POST">

            <input type="hidden" name="accion" value="actualizar">

            <table class="tabla">

                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio unitario</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acción</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($_SESSION["carrito"] as $id => $producto): ?>

                        <tr>

                            <td>
                                <?= htmlspecialchars($producto["nombre"]) ?>
                            </td>

                            <td>
                                <?= pesos($producto["precio"]) ?>
                            </td>

                            <td>
                                <input
                                    type="number"
                                    name="cantidades[<?= (int)$id ?>]"
                                    value="<?= (int)$producto["cantidad"] ?>"
                                    min="0"
                                    max="99">
                            </td>

                            <td>
                                <?= pesos($producto["precio"] * $producto["cantidad"]) ?>
                            </td>

                            <td>
                                <button
                                    type="button"
                                    class="eliminar"
                                    onclick="eliminarProducto(<?= (int)$id ?>)">
                                    Eliminar
                                </button>
                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

            <div class="acciones">

                <button type="submit">
                    Actualizar cantidades
                </button>

            </div>

        </form>

        <div class="total">
            Total a pagar: <?= pesos($total) ?>
        </div>

        <div class="acciones">

            <form method="POST">
                <input type="hidden" name="accion" value="vaciar">

                <button type="submit" class="vaciar">
                    Vaciar carrito
                </button>
            </form>

        </div>

        <form method="POST" id="formEliminar">
            <input type="hidden" name="accion" value="eliminar">
            <input type="hidden" name="id" id="idEliminar">
        </form>

        <script>
            function eliminarProducto(id) {
                if (confirm("¿Deseas eliminar este producto?")) {
                    document.getElementById("idEliminar").value = id;
                    document.getElementById("formEliminar").submit();
                }
            }
        </script>

    <?php endif; ?>

</main>

<footer>
    <p>Papelería San Carlos</p>
    <p>Sistema de gestión e inventario</p>
</footer>

</body>
</html>
