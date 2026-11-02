// Módulo de inicio de sesión de Papelería San Carlos.
<?php
// Inicia la sesión del usuario.
session_start();
// Conecta con la base de datos.
require_once "conexion.php";
// Variable para mostrar mensajes al usuario.
$mensaje = "";
// Verifica si el formulario fue enviado.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene el correo electrónico ingresado por el usuario. {
    $correo = trim($_POST["correo"] ?? "");
    // Obtiene la contraseña ingresada por el usuario.
    $contrasena = $_POST["contrasena"] ?? "";
// Consulta la base de datos para buscar el usuario activo por su correo.
    $sql = "SELECT id_usuario, nombre, correo, contrasena, rol
            FROM usuarios
            WHERE correo = ? AND estado = 'Activo'
            LIMIT 1";
// Prepara y ejecuta la consulta utilizando el correo ingresado.
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
// Obtiene el resultado de la consulta realizada en la base de datos.
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($contrasena, $usuario["contrasena"])) {
            $_SESSION["id_usuario"] = $usuario["id_usuario"];
            $_SESSION["nombre"] = $usuario["nombre"];
            $_SESSION["correo"] = $usuario["correo"];
            $_SESSION["rol"] = $usuario["rol"];

            header("Location: index.php");
            exit;
        } else {
            $mensaje = "Correo o contraseña incorrectos.";
        }
    } else {
        $mensaje = "Correo o contraseña incorrectos.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión | Papelería San Carlos</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #eaf2f8;
        }

        .contenedor {
            width: 90%;
            max-width: 400px;
            padding: 35px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.12);
        }

        h1 {
            text-align: center;
            color: #174a7e;
            font-size: 25px;
        }

        p {
            text-align: center;
            color: #555;
        }

        label {
            display: block;
            margin-top: 18px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-top: 7px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            width: 100%;
            margin-top: 25px;
            padding: 13px;
            border: none;
            border-radius: 6px;
            background: #174a7e;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #23669f;
        }

        .mensaje {
            margin-top: 15px;
            color: #c0392b;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="contenedor">
        <h1>Papelería San Carlos</h1>
        <p>Sistema de gestión de inventario y ventas</p>

        <form method="POST" action="login.php">

            <label for="correo">Correo electrónico</label>
            <input type="email" id="correo" name="correo"
                   placeholder="Ingrese su correo" required>

            <label for="contrasena">Contraseña</label>
            <input type="password" id="contrasena" name="contrasena"
                   placeholder="Ingrese su contraseña" required>

            <button type="submit">Iniciar sesión</button>

        </form>

        <?php if ($mensaje != ""): ?>
            <div class="mensaje">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
