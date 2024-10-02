let carrito = [];
let precioTotal = 0;

/**
 * Agrega un producto al carrito de compras.
 *
 * Si el producto ya está en el carrito, incrementa su cantidad.
 * De lo contrario, agrega un nuevo producto al carrito.
 *
 * @param {string} nombre - El nombre del producto.
 * @param {number} precio - El precio del producto.
 * @param {number} cantidad - La cantidad del producto a agregar.
 */
function agregarAlCarrito(nombre, precio, cantidad) {
    const item = carrito.find(item => item.nombre === nombre);
    if (item) {
        item.cantidad += parseInt(cantidad);
    } else {
        carrito.push({ nombre, precio, cantidad: parseInt(cantidad) });
    }
    actualizarCarrito();
}

/**
 * Actualiza el contenido del carrito en la interfaz de usuario.
 *
 * Muestra todos los productos en el carrito y calcula el precio total.
 */
function actualizarCarrito() {
    const itemsCarrito = document.getElementById('itemsCarrito');
    itemsCarrito.innerHTML = '';
    precioTotal = 0;

    carrito.forEach(item => {
        itemsCarrito.innerHTML += `<div class="item-carrito">
            ${item.nombre} - $${item.precio} x ${item.cantidad} <button onclick="eliminarDelCarrito('${item.nombre}')">Eliminar</button>
        </div>`;
        precioTotal += item.precio * item.cantidad;
    });

    document.getElementById('precioTotal').textContent = precioTotal.toFixed(2);
}

/**
 * Elimina un producto del carrito de compras.
 *
 * @param {string} nombre - El nombre del producto a eliminar.
 */
function eliminarDelCarrito(nombre) {
    carrito = carrito.filter(item => item.nombre !== nombre);
    actualizarCarrito();
}

/**
 * Procesa la compra de los productos en el carrito.
 *
 * Si el carrito no está vacío, calcula el total y el descuento 
 * (si corresponde), y envía los datos de la compra al servidor.
 */
function comprar() {
    if (carrito.length > 0) {
        let totalCompra = carrito.reduce((total, item) => total + (item.precio * item.cantidad), 0);
        let descuento = 0;
        if (totalCompra > 100) {
            descuento = totalCompra * 0.10;
            totalCompra -= descuento;
        }

        const compras = carrito.map(item => ({
            nombre: item.nombre, 
            precio: item.precio, 
            cantidad: item.cantidad,
            id: obtenerIdDelProducto(item.nombre) 
        }));

        fetch('procesar_compra.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ compras, total: totalCompra, descuento: descuento })
        })
        .then(response => response.text())
        .then(data => {
            console.log("Respuesta del servidor:", data); 
            if (data.includes("Compra procesada con éxito")) {
                window.location.href = 'generar_factura.php';
            } else {
                alert(data);
            }
            carrito = [];
            actualizarCarrito();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un problema al procesar la compra.');
        });
    } else {
        alert('El carrito está vacío.');
    }
}

// Mapa de identificación de productos
const ids = {
    'COCA-COLA': 1,
    'CERVEZA CORONA': 2,
    'BOM BOM BUM': 3,
    'CHOCOLATE BARRA': 4,
    'PAPAFRITA': 5,
    'GALLETAS CON CHIPS': 6,
    'GELATINA YELI': 7,
    'YOGURT DE COCO': 8,
    'AGUA': 9,
    'JUGO NATURAL': 10,
    'RED BULL': 12,
    'LECHE EN CAJA': 11,
};

/**
 * Obtiene el ID del producto según su nombre.
 *
 * @param {string} nombre - El nombre del producto.
 * @returns {number|undefined} El ID del producto o undefined si no se encuentra.
 */
function obtenerIdDelProducto(nombre) {
    return ids[nombre];
}

