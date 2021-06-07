<?php

require_once __DIR__.'/includes/config.php';

$idEventoTema = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$prevPage = filter_input(INPUT_GET, 'prevPage', FILTER_SANITIZE_STRING);

$form = new es\ucm\fdi\aw\eventosTemas\FormularioEditarEventoTema($idEventoTema, urldecode($prevPage));
$htmlFormEditarEventoTema = $form->gestiona();

$tituloPagina = 'Editar Evento/Tema';

$contenidoPrincipal = <<<EOS
    <h1>Editar Evento/Tema</h1>
    $htmlFormEditarEventoTema
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';