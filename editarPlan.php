<?php

require_once __DIR__.'/includes/config.php';

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$prevPage = filter_input(INPUT_GET, 'prevPage', FILTER_SANITIZE_STRING);


$form = new es\ucm\fdi\aw\suscripcion\FormularioEditarPlan($id, urldecode($prevPage));
$htmlFormEditarPlan= $form->gestiona();

$tituloPagina = 'Editar Plan';

$contenidoPrincipal = <<<EOS
    <h1>Editar Plan</h1>
    $htmlFormEditarPlan
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';