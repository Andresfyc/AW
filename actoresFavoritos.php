<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/usuarios_utils.php';

use es\ucm\fdi\aw\Aplicacion;

$tituloPagina = 'Actores Favoritos';
$contenidoPrincipal='<h1>Actores Favoritos</h1>';

function mostrarActoresFavoritos() {
	$app = Aplicacion::getSingleton();
	$RUTA_APP = RUTA_APP;
	$Usuario = getUsuario();
	$html="";
	$html .= listaActoresDirectoresUser($Usuario->user(), null, 0);
        
	return $html;
}


$contenidoPrincipal.= mostrarActoresFavoritos();


require __DIR__ . '/includes/plantillas/plantilla.php';