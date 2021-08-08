<?php
require('../../helpers/report.php');
require('../../models/productos.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Top 1o Productos con mas Existencias');
// Se instancia el módelo pedido para obtener los datos.
$producto = new Productos;
//Se verifica si existen datos, sino se imprime un mensaje
if ($dataProducto = $producto->productosStock()) {
    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->SetFillColor(26, 35, 120);
    //Se establece el color del texto
    $pdf->SetTextColor(255);
    // Se imprimen las celdas con los encabezados.
    $pdf->Cell(15, 10, utf8_decode('Top'), 1, 0, 'C', 1);
    $pdf->Cell(110, 10, utf8_decode('Producto'), 1, 0, 'C', 1);
    $pdf->Cell(62, 10, utf8_decode('En existencia'), 1, 1, 'C', 1);
    // Se establece un color de relleno para los encabezados.
    $pdf->SetFillColor(255);
    // Se establece la fuente para los encabezados.
    $pdf->SetFont('Arial', '', 11);
    //Se establece el color del texto
    $pdf->SetTextColor(0);
    //Se recorre el arreglo
    foreach ($dataProducto as $rowProducto) {
        // Se imprimen las celdas con los encabezados.
        $pdf->Cell(15, 10, ($rowProducto['num']), 1, 0, 'C', 1);
        $pdf->Cell(110, 10, utf8_decode($rowProducto['nombre_producto']), 1, 0, 'C', 1);
        $pdf->Cell(62, 10, ($rowProducto['cantidad']), 1, 1, 'C', 1);
    }

} else {
    $pdf->Cell(0, 10, utf8_decode('No hay productos :('), 1, 1);
}

// Se envía el documento al navegador y se llama al método Footer()
$pdf->Output();

?>