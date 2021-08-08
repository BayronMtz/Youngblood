<?php
    // Se verifica si existe el parámetro id en la url, de lo contrario se direcciona a la página web de origen.
    if (isset($_GET['id'])) {
        require('../../helpers/report.php');
        require('../../models/pedidos.php');
        // Se instancia el módelo Pedidos para procesar los datos.
        $pedido = new Pedidos;
        // Se verifica si el parámetro es un valor correcto, de lo contrario se direcciona a la página web de origen.
        if ($pedido->setIdPedido($_GET['id'])) {
            // Se instancia la clase para crear el reporte.
            $pdf = new Report;
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReportPublic('Factura');
            if ($dataPedido = $pedido->readOne()) {
                // Se establece un color de relleno para mostrar el nombre de la Puntuación.
                $pdf->SetFillColor(255);
                // Se establece la fuente.
                $pdf->SetFont('Arial', 'B', 12);
                // Se imprimen las celdas con los encabezados.
                $pdf->Cell(40, 10, utf8_decode('Fecha del Pedido: '), 0, 0, 'L', 1);
                // Se establece la fuente para los encabezados.
                $pdf->SetFont('Arial', '', 11);
                $pdf->Cell(75, 10, $dataPedido['fecha_pedido'], 0, 1, 'L', 1);
                // Se establece la fuente para el nombre de la Puntuación.
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->Cell(40, 10, utf8_decode('Estado del Pedido: '), 0, 0, 'L', 1);
                $pdf->SetFont('Arial', '', 11);
                $pdf->Cell(75, 10, $dataPedido['estado_pedido'], 0, 1, 'L', 1);
                //Se hace un salto de line
                $pdf->Ln();
                //Capturamos los datos del pedido
                if ($dataProducto = $pedido->readProductsOfOrder()) {
                    // Se establece un color de relleno para los encabezados.
                    $pdf->SetFillColor(255);
                    // Se establece la fuente para los encabezados.
                    $pdf->SetFont('Arial', 'B', 11);
                    // Se imprimen las celdas con los encabezados.
                    $pdf->Cell(70, 10, utf8_decode('Producto'), 1, 0, 'C', 1);
                    $pdf->Cell(35, 10, utf8_decode('Cantidad'), 1, 0, 'C', 1);
                    $pdf->Cell(40, 10, utf8_decode('Subtotal ($)'), 1, 0, 'C', 1);
                    $pdf->Cell(40, 10, utf8_decode('Precio ($)'), 1, 1, 'C', 1);
                    // Se establece la fuente para los datos de los productos
                    $pdf->SetFont('Arial', '', 11);
                    //recorremos los datos
                    foreach ($dataProducto as $rowProducto) {
                        // Se imprimen las celdas con los encabezados.
                        $pdf->Cell(70, 10, utf8_decode($rowProducto['nombre_producto']), 1, 0, 'C', 1);
                        $pdf->Cell(35, 10, utf8_decode($rowProducto['cantidad_producto']), 1, 0, 'C', 1);
                        $pdf->Cell(40, 10, utf8_decode($rowProducto['subtotal']), 1, 0, 'C', 1);
                        $pdf->Cell(40, 10, utf8_decode($rowProducto['precio']), 1, 1, 'C', 1);
                    }
                    //Se hace un salto de line
                    $pdf->Ln();
                    //Se imprime el total
                    if ($totalPedido = $pedido->getTotalPrice()) {
                        // Se establece la fuente para el nombre de la Puntuación.
                        $pdf->SetFont('Arial', 'B', 12);
                        $pdf->Cell(40, 10, utf8_decode('Total del Pedido: $'), 0, 0, 'L', 1);
                        $pdf->SetFont('Arial', '', 11);
                        $pdf->Cell(75, 10, $totalPedido['totalpedido'], 0, 1, 'L', 1);
                    } else {
                        $pdf->Cell(0, 10, utf8_decode('No se ha podido mostrar el total.'), 1, 1);
                    }

                } else {
                    $pdf->Cell(0, 10, utf8_decode('Este pedido no tiene productos.'), 1, 1);
                }
            } else {
                $pdf->Cell(0, 10, utf8_decode('Hubo error al mostrar el pedido.'), 1, 1);
            }

            // Se envía el documento al navegador y se llama al método Footer()
            $pdf->Output();
        } else {
            header('location: ../../../views/public/pedidos.php');
        }
    } else {
        header('location: ../../../views/public/pedidos.php');
    }
    
?>