<?php
// Se incluye la clase con las plantillas del documento.
require_once('../../app/helpers/public_page.php');
// Se imprime la plantilla del encabezado enviando el título de la página web.
Public_Page::headerTemplate('Be Brave, Be Young');
?>

<!-- Componente Slider con indicadores, altura de 400px y una duración entre transiciones de 6 segundos -->
<div class="slider" id="slider">
    <ul class="slides">
        <li>
            <img src="../../resources/img/slider/01.jpg" alt="Primera foto">
            <div class="caption center-align">
                <h2><b>La simplicidad es la clave de la verdadera elegancia.</b></h2>
                <h4>COCO CHANEL</h4>
            </div>
        </li>
        <li>
            <img src="../../resources/img/slider/02.jpg" alt="Segunda foto">
            <div class="caption left-align">
                <h2>Estilo es una manera de decir quien eres sin tener que hablar.</h2>
                <h4>Rachel Zoe</h4>
            </div>
        </li>
        <li>
            <img src="../../resources/img/slider/03.jpg" alt="Tercera foto">
            <div class="caption right-align">
                <h2>La felicidad esta en las pequeñas cosas,</h2>
                <h4>como estrenar ropa.</h4>
            </div>
        </li>
        <li>
            <img src="../../resources/img/slider/04.jpg" alt="Cuarta foto">
            <div class="caption center-align">
                <h2>La vida es demasiado corta para </h2>
                <h4>llevar ropa aburrida.</h4>
            </div>
        </li>
    </ul>
</div>

<!-- Contenedor para mostrar el catálogo de tipos de producto -->
<div class="container">
    <!-- Título del contenido principal -->
    <h4 class="center indigo-text" id="title">Nuestro catálogo</h4>
    <!-- Fila para mostrar las categorías disponibles -->
    <div class="row" id="categorias"></div>
</div>

<?php
// Se imprime la plantilla del pie enviando el nombre del controlador para la página web.
Public_Page::footerTemplate('index.js');
?>