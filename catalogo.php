
<?php
session_start();

// Productos disponibles
$productos = [
    [
        "id" => 1,
        "nombre" => "Cuaderno 100 hojas",
        "descripcion" => "Cuaderno argollado para uso escolar.",
        "precio" => 8500,
        "imagen" => "imagenes/cuaderno.png"
    ],
    [
        "id" => 2,
        "nombre" => "Lapicero negro",
        "descripcion" => "Lapicero de tinta negra.",
        "precio" => 2000,
        "imagen" => "imagenes/lapicero.png"
    ],
    [
        "id" => 3,
        "nombre" => "Resma de papel",
        "descripcion" => "Resma de papel tamaño carta.",
        "precio" => 18000,
        "imagen" => "imagenes/resma.png"
    ],
    [
        "id" => 4,
        "nombre" => "Caja de colores",
        "descripcion" => "Caja de colores x12 unidades.",
        "precio" => 12000,
        "imagen" => "imagenes/colores.png"
    ],
    [
        "id" => 5,
        "nombre" => "Borrador",
        "descripcion" => "Borrador escolar de dos colores.",
        "precio" => 1500,
        "imagen" => "imagenes/borrador.png"
    ],
    [
        "id" => 6,
        "nombre" => "Regla de 30 cm",
        "descripcion" => "Regla plástica para uso escolar.",
        "precio" => 2500,
        "imagen" => "imagenes/regla.png"
    ],
    [
        "id" => 7,
        "nombre" => "Sacapuntas",
        "descripcion" => "Sacapuntas plástico con depósito.",
        "precio" => 4000,
        "imagen" => "imagenes/sacapuntas.png"
    ],
    [
        "id" => 8,
        "nombre" => "Marcadores x12",
        "descripcion" => "Juego de marcadores de colores.",
        "precio" => 9500,
        "imagen" => "imagenes/marcadores.png"
    ],
    [
        "id" => 9,
        "nombre" => "Pegante en barra",
        "descripcion" => "Pegante escolar en barra.",
        "precio" => 3500,
        "imagen" => "imagenes/pegante.png"
    ],
    [
        "id" => 10,
        "nombre" => "Cartulina",
        "descripcion" => "Pliego de cartulina de colores.",
        "precio" => 1000,
        "imagen" => "imagenes/cartulina.png"
    ]
];

// Agregar producto al carrito
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["agregar"])) {

    $id = (int) $_POST["agregar"];

    foreach ($productos as $producto) {
        if ($producto["id"] == $id) {

            if (!isset($_SESSION["carrito"])) {
                $_SESSION["carrito"] = [];
            }

            if (isset($_SESSION["carrito"][$id])) {
                $_SESSION["carrito"][$id]["cantidad"]++;
            } else {
                $_SESSION["carrito"][$id] = [
                    "nombre" => $producto["nombre"],
                    "precio" => $producto["precio"],
                    "cantidad" => 1
                ];
            }

            break;
        }
    }

    header("Location: catalogo.php?agregado=1");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Catálogo - Papelería San Carlos</title>

    <link rel="stylesheet" href="estilos.css/estilos.css">

    <style>
        .catalogo {
            max-width: 1250px;
            margin: 30px auto;
            padding: 20px;
        }

        .productos {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 22px;
        }

        .producto {
            background: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 3px 12px rgba(0,0,0,0.10);
        }

        .producto img {
            width: 100%;
            height: 145px;
            object-fit: contain;
            margin-bottom: 15px;
        }

        .producto h3 {
            color: #222;
            min-height: 45px;
        }

        .descripcion {
            color: #666;
            font-size: 14px;
            min-height: 35px;
        }

        .precio {
            color: #008b45;
            font-size: 20px;
            font-weight: bold;
        }

        .disponible {
            color: #008b45;
            font-size: 14px;
        }

        .boton-carrito {
            background: #0866c5;
            color: white;
            border: none;
            padding: 12px 18px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }

        .boton-carrito:hover {
            background: #004b96;
        }

        .enlace-carrito {
            display: inline-block;
            background: #0866c5;
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .mensaje {
            color: green;
            font-weight: bold;
        }
    </style>
</head>

<body>

<header style="background:#0866c5;color:white;text-align:center;padding:20px;">
    <h1>Papelería San Carlos</h1>
    <p>Catálogo de productos</p>
</header>

<main class="catalogo">

    <h2>Productos disponibles</h2>

    <a href="carrito.php" class="enlace-carrito">
        Ver carrito de compras
        (<?php echo isset($_SESSION["carrito"]) ? array_sum(array_column($_SESSION["carrito"], "cantidad")) : 0; ?>)
    </a>

    <?php if (isset($_GET["agregado"])): ?>
        <p class="mensaje">Producto agregado correctamente al carrito.</p>
    <?php endif; ?>

    <section class="productos">

        <?php foreach ($productos as $producto): ?>

            <article class="producto">

                <img
                    src="<?php echo htmlspecialchars($producto["imagen"]); ?>"
                    alt="<?php echo htmlspecialchars($producto["nombre"]); ?>"
                    onerror="this.style.display='none';"
                >

                <h3><?php echo htmlspecialchars($producto["nombre"]); ?></h3>

                <p class="descripcion">
                    <?php echo htmlspecialchars($producto["descripcion"]); ?>
                </p>

                <p class="precio">
                    $<?php echo number_format($producto["precio"], 0, ',', '.'); ?>
                </p>

                <p class="disponible">Disponible</p>

                <form method="POST" action="catalogo.php">
                    <button
                        type="submit"
                        name="agregar"
                        value="<?php echo $producto["id"]; ?>"
                        class="boton-carrito">
                        Agregar al carrito
                    </button>
                </form>

            </article>

        <?php endforeach; ?>

    </section>

</main>

</body>
</html>
