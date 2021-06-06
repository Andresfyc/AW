<?php

require_once __DIR__.'/includes/config.php';


$form = new es\ucm\fdi\aw\suscripcion\FormularioNuevoPlan();
$htmlFormNuevoPlan = $form->gestiona();

$tituloPagina = 'Añadir Plan';

$contenidoPrincipal = <<<EOS

    $htmlFormNuevoPlan
EOS;

require __DIR__ . '/includes/plantillas/plantilla.php';