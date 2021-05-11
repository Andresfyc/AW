<?php

require_once __DIR__.'/includes/config.php';

$idEventoTema = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$nombreEventoTema = filter_input(INPUT_GET, 'nombre', FILTER_SANITIZE_STRING);
$timeEventoTema = filter_input(INPUT_GET, 'time', FILTER_SANITIZE_STRING);

$mensajes = new es\ucm\fdi\aw\mensajes();

$tituloPagina = $nombreEventoTema;

$contenidoPrincipal=<<<EOS
	<h1>{$nombreEventoTema}</h1>
EOS;

if ($timeEventoTema != NULL) {
	$contenidoPrincipal .= "<h3> Fecha y hora del evento: {$timeEventoTema}</h3>";
}
if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
    $contenidoPrincipal .= "<h3><a href=\"./nuevoMensaje.php?id={$idEventoTema}&nombre={$nombreEventoTema}&time={$timeEventoTema}\">Escribir nuevo mensaje</a></h3>";
}

$contenidoPrincipal .= $mensajes->listaMensajes($idEventoTema);

require __DIR__ . '/includes/plantillas/plantilla.php';