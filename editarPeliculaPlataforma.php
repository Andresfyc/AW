<?php

require_once __DIR__.'/includes/config.php';

$idPeliculaPlataforma = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$prevPage = filter_input(INPUT_GET, 'prevPage', FILTER_SANITIZE_STRING);

$form = new es\ucm\fdi\aw\plataformas\FormularioEditarPeliculaPlataforma($idPeliculaPlataforma, urldecode($prevPage));
$FormularioEditarPeliculaPlataforma = $form->gestiona();

$tituloPagina = 'Editar Link a Plataforma';

$contenidoPrincipal = <<<EOS
    <h1>Editar Link a Plataforma</h1>
    $FormularioEditarPeliculaPlataforma
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';