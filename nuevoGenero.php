<?php

require_once __DIR__.'/includes/config.php';

$prevPage = filter_input(INPUT_GET, 'prevPage', FILTER_SANITIZE_STRING);


$form = new es\ucm\fdi\aw\generos\FormularioNuevoGenero(urldecode($prevPage));
$htmlFormNuevoGenero = $form->gestiona();

$tituloPagina = 'Añadir Género';

$contenidoPrincipal = <<<EOS
<!--    <h1>Añadir Género</h1>-->
    $htmlFormNuevoGenero
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';