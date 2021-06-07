<?php

require_once __DIR__.'/includes/config.php';

$idActorDirector = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$prevPage = filter_input(INPUT_GET, 'prevPage', FILTER_SANITIZE_STRING);

$form = new es\ucm\fdi\aw\actoresDirectores\FormularioEditarActorDirector($idActorDirector,urldecode($prevPage));
$htmlFormEditarActorDirector = $form->gestiona();

$tituloPagina = 'Editar Actor/Director';

$contenidoPrincipal = <<<EOS
    <h1>Editar Actor/Director</h1>
    $htmlFormEditarActorDirector
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';