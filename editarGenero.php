<?php

require_once __DIR__.'/includes/config.php';

$idGenero = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$prevPage = filter_input(INPUT_GET, 'prevPage', FILTER_SANITIZE_STRING);

$form = new es\ucm\fdi\aw\generos\FormularioEditarGenero($idGenero, urldecode($prevPage));
$FormularioEditarGenero = $form->gestiona();

$tituloPagina = 'Editar Género';

$contenidoPrincipal = <<<EOS
    <h1>Editar Género</h1>
    $FormularioEditarGenero
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';