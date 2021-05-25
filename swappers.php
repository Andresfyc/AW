<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/usuarios_utils.php';

use es\ucm\fdi\aw\Aplicacion;

$tituloPagina = 'Swappers';
$contenidoPrincipal='<h1>Swappers agregados</h1>';

function mostrarSwappers() {
	$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
	$Usuario = getUsuarioPorUser($id);
	$html="";
	$html .= listaAmigos($Usuario->user(), null);
        
	return $html;
}


$contenidoPrincipal.= mostrarSwappers();


require __DIR__ . '/includes/plantillas/plantilla.php';