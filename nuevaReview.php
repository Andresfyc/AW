<?php

require_once __DIR__.'/includes/config.php';

$idPelicula = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$form = new es\ucm\fdi\aw\reviews\FormularioNuevaReview($idPelicula);
$htmlFormNuevaReview = $form->gestiona();

$tituloPagina = 'Añadir Review';

$contenidoPrincipal = <<<EOS
    <h1>Añadir Review</h1>
    $htmlFormNuevaReview
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';