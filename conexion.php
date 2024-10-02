<?php
/**
 * Conexión a la base de datos MySQL.
 *
 * Este script se encarga de establecer una conexión con la base de datos
 * `tienda_siscorp` utilizando las credenciales de acceso proporcionadas.
 *
 * @var string $host El servidor de la base de datos.
 * @var string $usuario El nombre de usuario para conectarse a la base de datos.
 * @var string $contrasena La contraseña para el usuario de la base de datos.
 * @var string $base_datos El nombre de la base de datos a la que se desea conectar.
 *
 * @var mysqli $conn La conexión a la base de datos. Si la conexión falla, se detiene la ejecución.
 * @throws mysqli_sql_exception Si la conexión no puede establecerse, se lanza una excepción.
 */
$host = "localhost";   //servidor de la base de datos 
$usuario = "root";    //usuario de la base de datos 
$contrasena = "";     //contraseña de la base de datos
$base_datos = "tienda_siscorp"; //nombre de la base de datos
//crear conexion con la base de datos 
$conn = new mysqli($host, $usuario, $contrasena, $base_datos);
//verificar si la conexion a fallado
if ($conn->connect_error) {
    //terminar con la ejecucion se la conexion a fallado
    die("Conexión fallida: " . $conn->connect_error);
}
?>
