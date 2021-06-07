<?php

require_once __DIR__.'/includes/config.php';

$peliculaId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$prevPage = filter_input(INPUT_GET, 'prevPage', FILTER_SANITIZE_STRING);


$form = new es\ucm\fdi\aw\plataformas\FormularioNuevaPeliculaPlataforma(urldecode($prevPage), $peliculaId);
$htmlFormNuevaPeliculaPlataforma = $form->gestiona();

$tituloPagina = 'Añadir Link a Plataforma';

$contenidoPrincipal = <<<EOS
    <h1>Añadir Link a Plataforma</h1>
    $htmlFormNuevaPeliculaPlataforma
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';