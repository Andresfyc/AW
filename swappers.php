<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/usuarios_utils.php';

use es\ucm\fdi\aw\Aplicacion;

$tituloPagina = 'Tus Swappers';
$contenidoPrincipal='<h1>Tus Swappers</h1>';

function mostrarSwappers() {
	$app = Aplicacion::getSingleton();
	$RUTA_APP = RUTA_APP;
	$Usuario = getUsuario();
	$html="";
	$html .= listaAmigos($Usuario->user(), null);
        
	return $html;
}


$contenidoPrincipal.= mostrarSwappers();


require __DIR__ . '/includes/plantillas/plantilla.php';