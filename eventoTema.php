<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/foro_utils.php';

use es\ucm\fdi\aw\Aplicacion;

$idEventoTema = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$nameEventoTema = filter_input(INPUT_GET, 'name', FILTER_SANITIZE_STRING);
$timeEventoTema = filter_input(INPUT_GET, 'time', FILTER_SANITIZE_STRING);

$tituloPagina = $nameEventoTema;

$contenidoPrincipal=<<<EOS
	<h1>{$nameEventoTema}</h1>
EOS;

if ($timeEventoTema != NULL) {
	$contenidoPrincipal .= "<h3> Fecha y hora del evento: {$timeEventoTema}</h3>";
}

$app = Aplicacion::getSingleton();
if ($app->usuarioLogueado()) {
    $contenidoPrincipal .= "<h3><a href=\"./nuevoMensaje.php?id={$idEventoTema}&nombre={$nameEventoTema}&time={$timeEventoTema}\">Escribir nuevo mensaje</a></h3>";
}

$contenidoPrincipal .= listaMensajes($idEventoTema);

require __DIR__ . '/includes/plantillas/plantilla.php';