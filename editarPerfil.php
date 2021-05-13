<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/usuarios_utils.php';

$user = filter_input(INPUT_GET, 'user', FILTER_SANITIZE_STRING);

$form = new es\ucm\fdi\aw\usuarios\FormularioEditarUsuario($user);
$htmlFormEditarUsuario = $form->gestiona();

$tituloPagina = 'Editar Usuario';

$contenidoPrincipal = <<<EOS
    <h1>Editar Usuario</h1>
    $htmlFormEditarUsuario
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';