<?php

require_once __DIR__.'/includes/config.php';

$prevPage = filter_input(INPUT_GET, 'prevPage', FILTER_SANITIZE_STRING);

$form = new es\ucm\fdi\aw\suscripcion\FormularioNuevoPlan(urldecode($prevPage));
$htmlFormNuevoPlan = $form->gestiona();

$tituloPagina = 'Añadir Plan';

$contenidoPrincipal = <<<EOS

    $htmlFormNuevoPlan
EOS;

require __DIR__ . '/includes/plantillas/plantilla.php';