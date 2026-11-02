
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$nombreUsuario = $_SESSION["nombre"] ?? "Administrador";
$rolUsuario = $_SESSION["rol"] ?? "administrador";

$paginaActual = basename($_SERVER["PHP_SELF"]);
?>

<header class="encabezado">

    <div class="marca">
        <div class="logo">📚</div>
        <div class="nombre-marca">
            <h1>Papelería <span>San Carlos</span></h1>
            <p>Sistema de Gestión</p>
        </div>
    </div>

    <div class="usuario">
        <span>Usuario: <?php echo htmlspecialchars($nombreUsuario); ?></span>
        <span class="rol">
            <?php echo htmlspecialchars($rolUsuario); ?>
        </span>
        <a href="cerrar_sesion.php" class="salir">Cerrar sesión</a>
    </div>

</header>

<nav class="menu">

    <a href="index.php"
       class="<?php echo $paginaActual == 'index.php' ? 'activo' : ''; ?>">
       Inicio
    </a>

    <a href="usuarios.php">Usuarios</a>
    <a href="clientes.php">Clientes</a>
    <a href="proveedores.php">Proveedores</a>
    <a href="productos.php">Productos</a>
    <a href="inventario.php">Inventario</a>
    <a href="compras.php">Compras</a>
    <a href="ventas.php">Ventas</a>
    <a href="reportes.php">Reportes</a>

</nav>
