<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/usuarios_utils.php';

$tituloPagina = 'Notificaciones';
$contenidoPrincipal='<h1>Notificaciones</h1>';

function mostrarNotificacionesUser() {

	$userIn = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
	$html="";
	$html .= listaNotificacionesUser($userIn);
        
	return $html;
}

$contenidoPrincipal.= mostrarNotificacionesUser();


require __DIR__ . '/includes/plantillas/plantilla.php';