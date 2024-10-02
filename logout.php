<?php
/**
 * Cierra la sesión del usuario.
 *
 * Este script finaliza la sesión del usuario actual
 * y redirige al usuario a la página de inicio de sesión.
 *
 * @return void No retorna ningún valor.
 */
session_start(); //inicia la sesion
session_destroy(); //destruye los datos de la sesion
header("Location: login.php");//envia al usuario a la pagina de inicio de sesion
exit(); //finaliza el script
?>
