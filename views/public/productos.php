<?php
// Se incluye la clase con las plantillas del documento.
require_once('../../app/helpers/public_page.php');
// Se imprime la plantilla del encabezado enviando el título de la página web.
Public_Page::headerTemplate('Productos por categría');
?>

<!-- Contenedor para mostrar los producto de la categoría seleccionada previamente -->
<div class="container">
    <!-- Título del contenido principal -->
    <h4 class="center indigo-text" id="title"></h4>
    <!-- Fila para mostrar los productos disponibles por categoría -->
    <div class="row" id="productos"></div>
</div>

<?php
// Se imprime la plantilla del pie enviando el nombre del controlador para la página web.
Public_Page::footerTemplate('productos.js');
?>