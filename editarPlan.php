<?php

require_once __DIR__.'/includes/config.php';

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);



$form = new es\ucm\fdi\aw\suscripcion\FormularioEditarPlan($id);
$htmlFormEditarPlan= $form->gestiona();

$tituloPagina = 'Editar Plan';

$contenidoPrincipal = <<<EOS
    <h1>Editar Plan</h1>
    $htmlFormEditarPlan
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';