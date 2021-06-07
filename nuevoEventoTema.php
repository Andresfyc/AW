<?php

require_once __DIR__.'/includes/config.php';

$prevPage = filter_input(INPUT_GET, 'prevPage', FILTER_SANITIZE_STRING);

$form = new es\ucm\fdi\aw\eventosTemas\FormularioNuevoEventoTema(urldecode($prevPage));
$htmlFormNuevoEventoTema = $form->gestiona();

$tituloPagina = 'Añadir Evento/Tema';

$contenidoPrincipal = <<<EOS
    <h1>Añadir evento/tema</h1>
    $htmlFormNuevoEventoTema
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';