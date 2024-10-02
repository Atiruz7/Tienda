<?php
include('conexion.php');
/**
 * Procesa el registro de un nuevo usuario.
 *
 * Este script recibe datos de un nuevo usuario desde un formulario y los 
 * inserta en la base de datos. Utiliza password_hash para almacenar la 
 * contraseña de manera segura. Si el registro es exitoso, muestra un 
 * mensaje de confirmación con un enlace para iniciar sesión.
 *
 * @global mysqli $conn Conexión a la base de datos.
 *
 * @return void No retorna ningún valor.
 */

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_usuario = $_POST['nombre_usuario'];//nombre de usuario proporcionado por el usuario
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT); //contraseña proporcionada por el usurio
    //consulta para mañadir al nuevo usuario
    $sql = "INSERT INTO usuarios (nombre_usuario, contrasena) VALUES ('$nombre_usuario', '$contrasena')";
    //ejecuta consulta
    if ($conn->query($sql) === TRUE) { //verific que es exitos 
        echo "Registro exitoso. <a href='login.php'>Iniciar sesión</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;//mensaje de error en caso de fallar
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="css/formulario.css">
</head>
<body>
    <div class="container">
        <h2>Registrarse</h2>
        <form method="POST" action="registro.php">
            <label for="nombre_usuario">Nombre de Usuario:</label>
            <input type="text" name="nombre_usuario" required>

            <label for="contrasena">Contraseña:</label>
            <input type="password" name="contrasena" required>

            <button type="submit">Registrarse</button>
        </form>
        <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
    </div>
</body>
</html>

