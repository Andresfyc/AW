<?php

require_once __DIR__.'/includes/config.php';

$user =$_SESSION["nombre"];

$peliculas = new es\ucm\fdi\aw\usuarios();
$pelicula = $peliculas->getUsuarioPorUser($user);

$form = new es\ucm\fdi\aw\FormularioEditarUsuario($user);
$htmlFormEditarUsuario = $form->gestiona();

$tituloPagina = 'Editar Usuario';

$contenidoPrincipal = <<<EOS
<h1>Editar Usuario</h1>
$htmlFormEditarUsuario
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';