<?php
require('../../helpers/report.php');
require('../../models/categorias.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Productos por Categoría');
// Se instancia el módelo categorias para obtener los datos.
$categoria = new Categorias;
// Se verifica si existen registros (categorías) para mostrar, de lo contrario se imprime un mensaje.
if ($dataCategoria = $categoria->readAll()) {
    // Se recorren los registros ($dataCategorias) fila por fila ($rowCategoria).
    foreach ($dataCategoria as $rowCategoria) {
        // Se establece un color de relleno para mostrar el nombre de la categoría.
        $pdf->SetFillColor(26, 35, 120);
        //Se establece el color del texto
        $pdf->SetTextColor(255);
        // Se imprime una celda con el nombre de la categoría.
        $pdf->Cell(0, 10, utf8_decode('Categoria: ' . $rowCategoria['nombre_categoria']), 1, 1, 'C', 1);
        //Se establece el color del texto
        $pdf->SetTextColor(0);
        // Se establece la categoría para obtener sus productos, de lo contrario se imprime un mensaje de error.
        if ($categoria->setId($rowCategoria['id_categoria'])) {
            // Se verifica si existen registros (productos) para mostrar, de lo contrario se imprime un mensaje.
            if ($dataProductos = $categoria->readAllByCategory()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->SetFillColor(225);
                // Se establece la fuente para los encabezados.
                $pdf->SetFont('Arial', 'B', 11);
                // Se imprimen las celdas con los encabezados.
                $pdf->Cell(130, 10, utf8_decode('Producto'), 1, 0, 'C', 1);
                $pdf->Cell(56, 10, utf8_decode('Precio $(USD)'), 1, 1, 'C', 1);
                // Se establece la fuente para los datos de los Pedidos.
                $pdf->SetFont('Arial', '', 11);
                // Se recorren los registros ($dataProductos) fila por fila ($rowProducto).
                foreach ($dataProductos as $rowProducto) {
                    // Se imprimen las celdas con los datos de los PRODUCTOS.
                    $pdf->Cell(130, 10, utf8_decode($rowProducto['nombre_producto']), 1, 0, 'C');
                    $pdf->Cell(56, 10, $rowProducto['precio_producto'], 1, 1, 'C');
                }
            } else {
                $pdf->Cell(0, 10, utf8_decode('No hay productos de esta categoria'), 1, 1);
            }
        } else {
            $pdf->Cell(0, 10, utf8_decode('Id incorrecto'), 1, 1);
        }
    }
} else {
    $pdf->Cell(0, 10, utf8_decode('No hay registros para mostrar'), 1, 1);
}

// Se envía el documento al navegador y se llama al método Footer()
$pdf->Output();

?>