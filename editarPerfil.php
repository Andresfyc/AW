<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/usuarios_utils.php';

$user = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
$prevPage = filter_input(INPUT_GET, 'prevPage', FILTER_SANITIZE_STRING);
$prevPageId = filter_input(INPUT_GET, 'prevId', FILTER_SANITIZE_NUMBER_INT);
$isSelf = filter_input(INPUT_GET, 'isSelf', FILTER_SANITIZE_NUMBER_INT);

if (strlen($prevPageId) > 0) {
    $prev = RUTA_APP . $prevPage . ".php?id=" . $prevPageId;
} else {
    $prev = RUTA_APP . $prevPage . ".php";
}

$form = new es\ucm\fdi\aw\usuarios\FormularioEditarUsuario($user, $prev, $isSelf);
$htmlFormEditarUsuario = $form->gestiona();

$tituloPagina = 'Editar Usuario';

$contenidoPrincipal = <<<EOS
    <h1>Editar Usuario</h1>
    $htmlFormEditarUsuario
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';