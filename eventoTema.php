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

$contenidoPrincipal .= $mensajes->listaMensajes($idEventoTema);

if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
	$form = new es\ucm\fdi\aw\FormularioNuevoMensaje($idEventoTema, $nombreEventoTema, $timeEventoTema);
	$htmlFormNuevoMensaje = $form->gestiona();

	$contenidoPrincipal .= <<<EOS
	<h4>Responder:</h4>
	$htmlFormNuevoMensaje
	EOS;
}

require __DIR__ . '/includes/plantillas/plantilla.php';