
<?php
require_once "conexion.php";

$nombre = "Administrador";
$correo = $correo = "ximses enaverde123@gmail.com";
$contrasena = "Admin123*";
$rol = "administrador";

$password = password_hash($contrasena, PASSWORD_DEFAULT);

$sql = "UPDATE usuarios
        SET password = ?
        WHERE correo = ?";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("ss", $password, $correo);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    echo "Contraseña del administrador actualizada correctamente.";
} else {
    echo "No se pudo actualizar. Verifica el correo registrado.";
}

$stmt->close();
$conexion->close();
?>
