<?php
// Se incluye la clase con las plantillas del documento.
require_once('../../app/helpers/dashboard_page.php');
// Se imprime la plantilla del encabezado enviando el título de la página web.
Dashboard_Page::headerTemplate('Bienvenido');
?>

<!-- Se muestra un saludo de acuerdo con la hora del cliente -->
<div class="row">
    <h4 class="center-align blue-text" id="greeting"></h4>
</div>

<div class="#">
    <!-- Se muestran las gráficas de acuerdo con algunos datos disponibles en la base de datos -->
    <div class="row valign-wrapper">
        <div class="valign col s12 m6">
            <!-- Se muestra una gráfica de barra con la cantidad de productos por categoría -->
            <canvas id="chart1"></canvas>
        </div>
        <div class="valign col s12 m6">
            <!-- Se muestra una gráfica de pastel con el porcentaje de productos por categoría -->
            <canvas id="chart3"></canvas>
        </div>
    </div>
    <div class="row valign-wrapper">
        <div class="valign col s12 m6" style="width: 400px;">
            <!-- Se muestra una gráfica de pastel con el porcentaje de productos por categoría -->
            <canvas id="chart6"></canvas>
        </div>
        <div class="valign col s12 m6" style="width: 400px;">
            <!-- Se muestra una gráfica de pastel con el porcentaje de productos por categoría -->
            <canvas id="chart4"></canvas>
        </div>
    </div>
    <div class="row valign" >
        <div class="valign col s12">
            <!-- Se muestra una gráfica de pastel con el porcentaje de productos por categoría -->
            <canvas id="chart5"></canvas>
        </div>
    </div>
</div>

<!-- Importación del archivo para generar gráficas en tiempo real. Para más información https://www.chartjs.org/ -->
<script type="text/javascript" src="../../resources/js/chart.js"></script>

<?php
// Se imprime la plantilla del pie enviando el nombre del controlador para la página web.
Dashboard_Page::footerTemplate('main.js');
?>
