<?php

require_once __DIR__.'/includes/config.php';

$form = new es\ucm\fdi\aw\usuarios\FormularioLogin();
$htmlFormLogin = $form->gestiona();

$tituloPagina = 'Login';

$contenidoPrincipal = <<<EOS
<!--<h1 class="loginTitulo">Login</h1>-->

$htmlFormLogin
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';