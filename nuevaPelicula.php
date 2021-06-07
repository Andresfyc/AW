<?php

require_once __DIR__.'/includes/config.php';

$prevPage = filter_input(INPUT_GET, 'prevPage', FILTER_SANITIZE_STRING);

$form = new es\ucm\fdi\aw\peliculas\FormularioNuevaPelicula(urldecode($prevPage));
$htmlFormNuevaPelícula = $form->gestiona();

$tituloPagina = 'Añadir Película';

$contenidoPrincipal = <<<EOS
    <h1>Añadir Película</h1>
    $htmlFormNuevaPelícula
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';