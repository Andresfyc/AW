<?php

require_once __DIR__.'/includes/config.php';

$idEvento = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$nombreEvento = filter_input(INPUT_GET, 'nombre', FILTER_SANITIZE_STRING);

$mensajes = new es\ucm\fdi\aw\mensajes();

$tituloPagina = $nombreEvento;

$contenidoPrincipal=<<<EOS
	<h1>{$nombreEvento}</h1>
EOS;

$contenidoPrincipal .= $mensajes->listaMensajes($idEvento);


require __DIR__ . '/includes/plantillas/plantilla.php';