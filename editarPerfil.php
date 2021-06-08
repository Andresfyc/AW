<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/usuarios_utils.php';

$user = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
$prevPage = filter_input(INPUT_GET, 'prevPage', FILTER_SANITIZE_STRING);
$isSelf = filter_input(INPUT_GET, 'isSelf', FILTER_SANITIZE_NUMBER_INT);

$form = new es\ucm\fdi\aw\usuarios\FormularioEditarUsuario($user, urldecode($prevPage), $isSelf);
$htmlFormEditarUsuario = $form->gestiona();

$tituloPagina = 'Editar Usuario';

$contenidoPrincipal = <<<EOS
    
   
    $htmlFormEditarUsuario
    
    <script src="js/editarPerfil.js"> </script>
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';