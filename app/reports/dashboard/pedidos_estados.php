<?php
require('../../helpers/report.php');
require('../../models/pedidos.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Pedidos por Estado');

// Se instancia el módelo pedido para obtener los datos.
$pedido = new Pedidos;

if ($estadoPedido = $pedido->readEstados()) {
    // Se establece un color de relleno para mostrar el nombre de la categoría.
    $pdf->SetFillColor(255);
    //Se establece el color del texto
    $pdf->SetTextColor(0);
    // Se imprimen celdas indicando la definición de cada número
    $pdf->Cell(0, 10, utf8_decode('1 = Finalizado'), 0, 1, 'C', 1);
    $pdf->Cell(0, 10, utf8_decode('2 = Entregado'), 0, 1, 'C', 1);
    $pdf->Cell(0, 10, utf8_decode('3 = Anulado'), 0, 1, 'C', 1);
    $pdf->Cell(0, 10, utf8_decode(' '), 0, 1, 'C', 1);

    // Se recorren los registros ($dataPedido) fila por fila ($rowEstado).
    foreach ($estadoPedido as $rowEstado) {
        // Se establece un color de relleno para mostrar el nombre de la categoría.
        $pdf->SetFillColor(26, 35, 120);
        //Se establece el color del texto
        $pdf->SetTextColor(255);
        // Se imprime una celda con el nombre de la categoría.
        $pdf->Cell(0, 10, utf8_decode('Estado: ' . $rowEstado['estado_pedido']), 1, 1, 'C', 1);
        //Se establece el color del texto
        $pdf->SetTextColor(0);
        // Se establece la categoría para obtener sus Pedidos, de lo contrario se imprime un mensaje de error.
        if ($pedido->setEstado($rowEstado['estado_pedido'])) {
            // Se verifica si existen registros (Pedidos) para mostrar, de lo contrario se imprime un mensaje.
            if ($dataPedido = $pedido->readAllByState()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->SetFillColor(225);
                // Se establece la fuente para los encabezados.
                $pdf->SetFont('Arial', 'B', 11);
                // Se imprimen las celdas con los encabezados.
                $pdf->Cell(130, 10, utf8_decode('Cliente'), 1, 0, 'C', 1);
                $pdf->Cell(56, 10, utf8_decode('Fecha (AAAA-MM-DD)'), 1, 1, 'C', 1);
                // Se establece la fuente para los datos de los Pedidos.
                $pdf->SetFont('Arial', '', 11);
                // Se recorren los registros ($dataPedidos) fila por fila ($rowPedido).
                foreach ($dataPedido as $rowPedido) {
                    // Se imprimen las celdas con los datos de los Pedidos.
                    $pdf->Cell(130, 10, utf8_decode($rowPedido['cliente']), 1, 0, 'C');
                    $pdf->Cell(56, 10, $rowPedido['fecha_pedido'], 1, 1, 'C');
                }
            } else {
                $pdf->Cell(0, 10, utf8_decode('No hay pedidos en este estado.'), 1, 1);
            }
        } else {
            $pdf->Cell(0, 10, utf8_decode('Id incorrecto'), 1, 1);
        }
    }
} else {
    $pdf->Cell(0, 10, utf8_decode('No hay pedidos para mostrar'), 1, 1);
}

// Se envía el documento al navegador y se llama al método Footer()
$pdf->Output();

?>
