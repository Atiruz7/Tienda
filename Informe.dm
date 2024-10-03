Informe del Proyecto: "Tienda"
Lenguajes de Programación:
JavaScript: para Manejo de la lógica del cliente y gestión de interacción con el carrito de compras.
PHP: Backend para gestionar operaciones como registro de usuarios, autenticación y transacciones.
CSS: Diseño de la interfaz gráfica del usuario (UI), aplicando estilos a formularios, tablas y botones para una mejor experiencia visual.

Base de Datos :MySQL

Este proyecto implementa un sistema de tienda en línea que permite a los usuarios:
-Registrarse e iniciar sesión.
-Navegar por los productos y agregarlos a un carrito de compras.
-Gestionar su carrito, incluyendo la posibilidad de eliminar productos.
-Procesar la compra y obtener un historial de compras.

Funcionalidades Principales:
Conexión a la base de datos (PHP): El archivo conexion.php contiene la lógica para conectar con la base de datos MySQL, usando credenciales del servidor (host, usuario, contraseña y nombre de la base).
Registro de Usuarios (PHP): El archivo registro.php permite a los usuarios crear cuentas y almacenar contraseñas de forma segura.
Iniciar Sesión/Logout (PHP): Autenticación de usuarios en sesiones con validación de credenciales.
El archivo logout.php gestiona el cierre de sesión.
Carrito de Compras (JavaScript): Lógica en el frontend para agregar y eliminar productos del carrito, calcular el total y aplicar descuentos si es necesario.
Procesar Compra (PHP): El archivo procesar_compra.php maneja la lógica para almacenar las compras y calcular descuentos para los usuarios, interactuando con la base de datos.
Historial de Compras (PHP): historial_compras.php muestra un resumen de todas las compras realizadas por el usuario, con detalles como fecha, productos, totales y descuentos.
Generación de Factura (PHP): Tras una compra exitosa, se genera una factura en un archivo de texto (ventas.txt), que incluye detalles de la transacción y descuentos aplicados.
