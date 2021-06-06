<?php

require_once __DIR__.'/includes/config.php';

$prevPage = filter_input(INPUT_GET, 'prevPage', FILTER_SANITIZE_STRING);
$prevPageId = filter_input(INPUT_GET, 'prevId', FILTER_SANITIZE_NUMBER_INT);

if (strlen($prevPageId) > 0) {
    $prev = RUTA_APP . $prevPage . ".php?id=" . $prevPageId;
} else {
    $prev = RUTA_APP . $prevPage . ".php";
}

$form = new es\ucm\fdi\aw\peliculas\FormularioNuevaPelicula();
$htmlFormNuevaPelícula = $form->gestiona($prev);

$tituloPagina = 'Añadir Película';

$contenidoPrincipal = <<<EOS
    <h1>Añadir Película</h1>
    $htmlFormNuevaPelícula
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';