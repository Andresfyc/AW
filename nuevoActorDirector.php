<?php

require_once __DIR__.'/includes/config.php';

$prevPage = filter_input(INPUT_GET, 'prevPage', FILTER_SANITIZE_STRING);
$prevPageId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$ad = filter_input(INPUT_GET, 'ad', FILTER_SANITIZE_NUMBER_INT);

if (strlen($prevPageId) > 0) {
    $prev = "./" . $prevPage . ".php?id=" . $prevPageId;
} else {
    $prev = "./" . $prevPage . ".php";
}


$form = new es\ucm\fdi\aw\FormularioNuevoActorDirector($ad, $prev);
$htmlFormNuevoActorDirector = $form->gestiona();

$tituloPagina = 'Añadir Actor/Director';

$contenidoPrincipal = <<<EOS
<h1>Añadir Actor/Director</h1>
$htmlFormNuevoActorDirector
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';