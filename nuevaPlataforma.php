<?php

require_once __DIR__.'/includes/config.php';

$prevPage = filter_input(INPUT_GET, 'prevPage', FILTER_SANITIZE_STRING);

$form = new es\ucm\fdi\aw\plataformas\FormularioNuevaPlataforma(urldecode($prevPage));
$htmlFormNuevaPlataforma = $form->gestiona();

$tituloPagina = 'Añadir Plataforma';

$contenidoPrincipal = <<<EOS
    <h1>Añadir Plataforma</h1>
    $htmlFormNuevaPlataforma
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';