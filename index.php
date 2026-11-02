
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Papelería San Carlos</title>
    <link rel="stylesheet" href="estilos.css/estilos.css">
</head>
<body>

    <?php include "encabezado.php"; ?>

    <main class="contenido">

        <h2>Panel principal</h2>
        <p>Bienvenido al sistema de gestión de Papelería San Carlos.</p>

        <section class="panel-modulos">

            <a href="productos.php" class="modulo">
                <h3>Productos</h3>
                <p>Consultar y administrar productos.</p>
            </a>

            <a href="inventario.php" class="modulo">
                <h3>Inventario</h3>
                <p>Controlar existencias y stock.</p>
            </a>

            <a href="clientes.php" class="modulo">
                <h3>Clientes</h3>
                <p>Gestionar información de clientes.</p>
            </a>

            <a href="proveedores.php" class="modulo">
                <h3>Proveedores</h3>
                <p>Administrar proveedores.</p>
            </a>

            <a href="ventas.php" class="modulo">
                <h3>Ventas</h3>
                <p>Registrar y consultar ventas.</p>
            </a>

            <a href="compras.php" class="modulo">
                <h3>Compras</h3>
                <p>Gestionar compras de mercancía.</p>
            </a>

            <a href="usuarios.php" class="modulo">
                <h3>Usuarios</h3>
                <p>Administrar usuarios del sistema.</p>
            </a>

            <a href="reportes.php" class="modulo">
                <h3>Reportes</h3>
                <p>Consultar información del negocio.</p>
            </a>

        </section>

    </main>

    <footer>
        <p>© 2026 Papelería San Carlos - Sistema de gestión</p>
    </footer>

</body>
</html>

