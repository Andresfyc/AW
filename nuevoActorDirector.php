<?php

require_once __DIR__.'/includes/config.php';

$prevPage = filter_input(INPUT_GET, 'prevPage', FILTER_SANITIZE_STRING);
$ad = filter_input(INPUT_GET, 'ad', FILTER_SANITIZE_NUMBER_INT);


$form = new es\ucm\fdi\aw\actoresDirectores\FormularioNuevoActorDirector($ad, urldecode($prevPage));
$htmlFormNuevoActorDirector = $form->gestiona();

if ($ad == 0) {
    $adString = 'Actor';
} else {
    $adString = 'Director';
}

$tituloPagina = "Añadir {$adString}";

$contenidoPrincipal = <<<EOS
    <h1>Añadir $adString</h1>
    $htmlFormNuevoActorDirector
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';