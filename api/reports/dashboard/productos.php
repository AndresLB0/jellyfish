<?php
require('../../helpers/dashboard_report.php');
require('../../models/productos.php');
require('../../models/tipoproducto.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Productos por tipo de producto');

// Se instancia el módelo Categorías para obtener los datos.
$tipoproducto = new tipo_producto;
// Se verifica si existen registros (categorías) para mostrar, de lo contrario se imprime un mensaje.
if ($datatipoproductos = $tipoproducto->readAll()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(80, 80, 200);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Times', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(126, 10, utf8_decode('Nombre'), 1, 0, 'C', 1);
    $pdf->cell(30, 10, utf8_decode('Precio (US$)'), 1, 0, 'C', 1);
    $pdf->cell(30, 10, utf8_decode('marca'), 1, 1, 'C', 1);

    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->setFillColor(100, 149, 237);
    // Se establece la fuente para los datos de los productos.
    $pdf->setFont('Times', '', 11);

    // Se recorren los registros ($datatipoproductos) fila por fila ($rowtipoproducto).
    foreach ($datatipoproductos as $rowtipoproducto) {
        // Se imprime una celda con el nombre de la categoría.
        $pdf->cell(0, 10, utf8_decode('tipo de producto: '.$rowtipoproducto['tipo_producto']), 1, 1, 'C', 1);
        // Se instancia el módelo Productos para procesar los datos.
        $producto = new Productos;
        // Se establece la categoría para obtener sus productos, de lo contrario se imprime un mensaje de error.
        if ($producto->setTipoproducto($rowtipoproducto['idtipo_producto'])) {
            // Se verifica si existen registros (productos) para mostrar, de lo contrario se imprime un mensaje.
            if ($dataProductos = $producto->ProductosTipo()) {
                // Se recorren los registros ($dataProductos) fila por fila ($rowProducto).
                foreach ($dataProductos as $rowProducto) {
                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->cell(126, 10, utf8_decode($rowProducto['nombre_producto']), 1, 0);
                    $pdf->cell(30, 10, $rowProducto['precio_producto'], 1, 0);
                    $pdf->cell(30, 10,$rowProducto['nombre_marca'], 1, 1);
                }
            } else {
                $pdf->cell(0, 10, utf8_decode('No hay productos para esta categoría'), 1, 1);
            }
        } else {
            $pdf->cell(0, 10, utf8_decode('Categoría incorrecta o inexistente'), 1, 1);
        }
    }
} else {
    $pdf->cell(0, 10, utf8_decode('No hay categorías para mostrar'), 1, 1);
}

// Se envía el documento al navegador y se llama al método footer()
$pdf->output('I', 'productos.pdf');
