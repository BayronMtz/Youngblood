<?php
require('../../helpers/report.php');
require('../../models/pedidos.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Top 25 de Clientes con más Compras');
// Se instancia el módelo pedido para obtener los datos.
$pedido = new Pedidos;
//Se verifica si existen datos, sino se imprime un mensaje
if ($dataClientes = $pedido->comprasClientes()) {
    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->SetFillColor(26, 35, 120);
    //Se establece el color del texto
    $pdf->SetTextColor(255);
    // Se imprimen las celdas con los encabezados.
    $pdf->Cell(15, 10, utf8_decode('Top'), 1, 0, 'C', 1);
    $pdf->Cell(110, 10, utf8_decode('Cliente'), 1, 0, 'C', 1);
    $pdf->Cell(62, 10, utf8_decode('Productos Comprados'), 1, 1, 'C', 1);
    // Se establece un color de relleno para los encabezados.
    $pdf->SetFillColor(255);
    // Se establece la fuente para los encabezados.
    $pdf->SetFont('Arial', '', 11);
    //Se establece el color del texto
    $pdf->SetTextColor(0);
    //Se recorre el arreglo
    foreach ($dataClientes as $rowCliente) {
        // Se imprimen las celdas con los encabezados.
        $pdf->Cell(15, 10, ($rowCliente['num']), 1, 0, 'C', 1);
        $pdf->Cell(110, 10, utf8_decode($rowCliente['clientes']), 1, 0, 'C', 1);
        $pdf->Cell(62, 10, ($rowCliente['comprados']), 1, 1, 'C', 1);
    }

} else {
    $pdf->Cell(0, 10, utf8_decode('Ningun cliente ha comprado productos :('), 1, 1);
}

// Se envía el documento al navegador y se llama al método Footer()
$pdf->Output();

?>