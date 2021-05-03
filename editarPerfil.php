<?php

require_once __DIR__.'/includes/config.php';

$user =$_SESSION["nombre"];

$usuarios = new es\ucm\fdi\aw\usuarios();
$usuario = $usuarios->getUsuarioPorUser($user);

$form = new es\ucm\fdi\aw\FormularioEditarUsuario($usuario);
$htmlFormEditarUsuario = $form->gestiona();

$tituloPagina = 'Editar Usuario';

$contenidoPrincipal = <<<EOS
<h1>Editar Usuario</h1>
$htmlFormEditarUsuario
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';