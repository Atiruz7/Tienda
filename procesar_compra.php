<?php
include('conexion.php');
session_start();
date_default_timezone_set('America/La_Paz');
/**
 * Procesa una compra realizada por un usuario.
 *
 * Este script verifica si el usuario ha iniciado sesión. Si no es así,
 * redirige al usuario a la página de inicio de sesión. Luego, recibe 
 * datos de la compra en formato JSON, verifica el stock de los productos 
 * y registra la venta en la base de datos. Si hay suficiente stock, 
 * se actualiza la cantidad de productos; de lo contrario, se lanzan
 * excepciones y se hace un rollback de la transacción.
 *
 * @global mysqli $conn Conexión a la base de datos.
 * @throws Exception Si hay problemas con la base de datos o si hay
 *                   problemas de stock.
 *
 * @return void No retorna ningún valor.
 */
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php"); 
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);
    $compras = $data['compras']; //lista de compras 
    $total = $data['total']; //total de compra
    $descuento = $data['descuento']; //descuento correspondiente

    $usuario_id = $_SESSION['usuario_id'];
    $conn->begin_transaction(); //transaccion

    try {
        //proceso de compra
        foreach ($compras as $compra) {
            $id_producto = $compra['id'];
            $cantidad_comprada = $compra['cantidad'];

            //verifica cantidad disponible de los productos
            $stmt = $conn->prepare("SELECT cantidad FROM productos WHERE id = ?");
            $stmt->bind_param('i', $id_producto);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $cantidad_actual = $row['cantidad'];

                if ($cantidad_actual >= $cantidad_comprada) {
                    $nueva_cantidad = $cantidad_actual - $cantidad_comprada;
                    $stmt_update = $conn->prepare("UPDATE productos SET cantidad = ? WHERE id = ?");
                    $stmt_update->bind_param('ii', $nueva_cantidad, $id_producto);                    
                    if (!$stmt_update->execute()) {
                        throw new Exception("Error al actualizar el stock: " . $conn->error);
                    }
                } else {
                    throw new Exception("No hay suficiente stock para el producto con ID $id_producto.");
                }
            } else {
                throw new Exception("Producto con ID $id_producto no encontrado.");
            }
        }

        //ingresa la venta a la base de datos
        $fecha_actual = date("Y-m-d H:i:s");
        $stmt_insert = $conn->prepare("INSERT INTO ventas (usuario_id, total, fecha) VALUES (?, ?, ?)");
        $stmt_insert->bind_param('ids', $usuario_id, $total, $fecha_actual);

        if ($stmt_insert->execute()) {
            $_SESSION['carrito'] = $compras; //guarda el carrito de compras
            $conn->commit();
            echo "Compra procesada con éxito";
        } else {
            throw new Exception("Error al registrar la venta: " . $conn->error);
        }
    } catch (Exception $e) {
        $conn->rollback();// caso de error Rollback
        echo $e->getMessage();//mensaje de error
    }
}
?>
