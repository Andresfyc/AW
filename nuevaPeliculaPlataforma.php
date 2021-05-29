<?php

require_once __DIR__.'/includes/config.php';

$peliculaId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$prevPage = filter_input(INPUT_GET, 'prevPage', FILTER_SANITIZE_STRING);
$prevPageId = filter_input(INPUT_GET, 'prevId', FILTER_SANITIZE_NUMBER_INT);

if (strlen($prevPageId) > 0) {
    $prev = RUTA_APP . $prevPage . ".php?id=" . $prevPageId;
} else {
    $prev = RUTA_APP . $prevPage . ".php";
}


$form = new es\ucm\fdi\aw\plataformas\FormularioNuevaPeliculaPlataforma($prev, $peliculaId);
$htmlFormNuevaPeliculaPlataforma = $form->gestiona();

$tituloPagina = 'Añadir Link a Plataforma';

$contenidoPrincipal = <<<EOS
    <h1>Añadir Link a Plataforma</h1>
    $htmlFormNuevaPeliculaPlataforma
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';