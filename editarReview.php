<?php

require_once __DIR__.'/includes/config.php';

$idReview = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$prevPage = filter_input(INPUT_GET, 'prevPage', FILTER_SANITIZE_STRING);

$form = new es\ucm\fdi\aw\reviews\FormularioEditarReview($idReview, urldecode($prevPage));
$FormularioEditarReview = $form->gestiona();

$tituloPagina = 'Editar Review';

$contenidoPrincipal = <<<EOS
    <h1>Editar Review</h1>
    $FormularioEditarReview
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';