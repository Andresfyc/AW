<?php

require_once __DIR__.'/includes/config.php';

$idEventoTema = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$prevPage = filter_input(INPUT_GET, 'prevPage', FILTER_SANITIZE_STRING);
$prevPageId = filter_input(INPUT_GET, 'prevId', FILTER_SANITIZE_NUMBER_INT);

if (strlen($prevPageId) > 0) {
    $prev = RUTA_APP . $prevPage . ".php?id=" . $prevPageId;
} else {
    $prev = RUTA_APP . $prevPage . ".php";
}

$form = new es\ucm\fdi\aw\eventosTemas\FormularioEditarEventoTema($idEventoTema, $prev);
$htmlFormEditarEventoTema = $form->gestiona();

$tituloPagina = 'Editar Evento/Tema';

$contenidoPrincipal = <<<EOS
    <h1>Editar Evento/Tema</h1>
    $htmlFormEditarEventoTema
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';