<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/usuarios_utils.php';

$tituloPagina = 'Swappers';
$contenidoPrincipal='<h1>Swappers agregados</h1>';

function mostrarSwappers() {
	$userIn = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
	$html="";
	$html .= listaAmigos($userIn, null);
        
	return $html;
}


$contenidoPrincipal.= mostrarSwappers();


require __DIR__ . '/includes/plantillas/plantilla.php';