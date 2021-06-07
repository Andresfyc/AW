<?php

require_once __DIR__.'/includes/config.php';

$idPlataforma = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$prevPage = filter_input(INPUT_GET, 'prevPage', FILTER_SANITIZE_STRING);

$form = new es\ucm\fdi\aw\plataformas\FormularioEditarPlataforma($idPlataforma, urldecode($prevPage));
$FormularioEditarPlataforma = $form->gestiona();

$tituloPagina = 'Editar Plataforma';

$contenidoPrincipal = <<<EOS
    <h1>Editar Plataforma</h1>
    $FormularioEditarPlataforma
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';