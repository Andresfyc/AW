<?php

require_once __DIR__.'/includes/config.php';

$prevPage = filter_input(INPUT_GET, 'prevPage', FILTER_SANITIZE_STRING);

$form = new es\ucm\fdi\aw\usuarios\FormularioLogin(urldecode($prevPage));
$htmlFormLogin = $form->gestiona();

$tituloPagina = 'Login';

$contenidoPrincipal = <<<EOS

        $htmlFormLogin
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';