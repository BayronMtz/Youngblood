<?php
// Se verifica si existe el parámetro id en la url, de lo contrario se direcciona a la página web de origen.
if (isset($_GET['id'])) {
    require('../../helpers/report.php');
    require('../../models/valoraciones.php');
    // Se instancia el módelo valoraciones para procesar los datos.
    $valoracion = new Valoraciones();
    // Se verifica si el parámetro es un valor correcto, de lo contrario se direcciona a la página web de origen.
    if ($valoracion->setIdCliente($_GET['id'])) {
        // Se verifica si la categoría del parametro existe, de lo contrario se direcciona a la página web de origen.
        if ($dataCliente = $valoracion->readClient()) {
            // Se instancia la clase para crear el reporte.
            $pdf = new Report;
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Comentarios realizados por '.$dataCliente['cliente']);
            // Se verifica si existen registros (Productos) para mostrar, de lo contrario se imprime un mensaje.
            if ($dataProducto = $valoracion->getProducts()) {
                // Se recorren los registros ($dataProducto) fila por fila ($rowProducto).
                foreach ($dataProducto as $rowProducto) {
                    // Se establece un color de relleno para mostrar el nombre de la categoría.
                    $pdf->SetFillColor(26, 35, 120);
                    //Se establece el color del texto
                    $pdf->SetTextColor(255);
                    // Se imprime una celda con el nombre del producto.
                    $pdf->Cell(0, 10, utf8_decode('Producto: ' . $rowProducto['nombre_producto']), 1, 1, 'C', 1);
                    //Se establece el color del texto
                    $pdf->SetTextColor(0);
                    //Se envia el parametro del producto
                    if ($valoracion->setIdProducto($rowProducto['id_producto'])) {
                        // Se establece un color de relleno para los encabezados.
                        $pdf->SetFillColor(225);
                        // Se establece la fuente para los encabezados.
                        $pdf->SetFont('Arial', 'B', 11);
                        // Se guardan los comentarios obtenidos por el id producto enviado
                        if ($dataValoracion = $valoracion->getReviewsByProduct()) {
                            // Se imprimen las celdas con los encabezados.
                            $pdf->Cell(90, 10, utf8_decode('Valoracion'), 1, 0, 'C', 1);
                            $pdf->Cell(56, 10, ('Fecha (AAAA-MM-DD)'), 1, 0, 'C', 1);
                            $pdf->Cell(40, 10, utf8_decode('Puntuación'), 1, 1, 'C', 1);
                            // Se establece un color de relleno para los encabezados.
                            $pdf->SetFillColor(255);
                            // Se establece la fuente para los encabezados.
                            $pdf->SetFont('Arial', '', 11);
                            // Se recorren los registros ($dataValoracion) fila por fila ($rowValoracion).
                            foreach ($dataValoracion as $rowValoracion) {
                                $pdf->Cell(90, 10, utf8_decode($rowValoracion['valoracion']), 1, 0, 'C', 1);
                                $pdf->Cell(56, 10, utf8_decode($rowValoracion['fecha']), 1, 0, 'C', 1);
                                $pdf->Cell(40, 10, utf8_decode($rowValoracion['puntuacion']), 1, 1, 'C', 1);
                            }
                        } else {
                            $pdf->Cell(0, 10, utf8_decode('El cliente no ha hecho valoraciones para este producto.'), 1, 1);
                        }
                        
                    } else {
                        $pdf->Cell(0, 10, utf8_decode('Id incorrecto'), 1, 1);
                    }
                    
                }

            } else {
                $pdf->Cell(0, 10, utf8_decode('No hay productos para mostrar.'), 1, 1);
            }

            // Se envía el documento al navegador y se llama al método Footer()
            $pdf->Output();
            
        } else {
            //header('location: ../../../views/dashboard/clientes.php');
        }
    } else {
        header('location: ../../../views/dashboard/clientes.php');
    }
} else {
    header('location: ../../../views/dashboard/clientes.php');
}




?>