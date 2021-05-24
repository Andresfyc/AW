<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/usuarios_utils.php';

use es\ucm\fdi\aw\Aplicacion;

$tituloPagina = 'Directores Favoritos';
$contenidoPrincipal='<h1>Directores Favoritos</h1>';

function mostrarDirectoresFavoritos() {
	$app = Aplicacion::getSingleton();
	$RUTA_APP = RUTA_APP;
	$Usuario = getUsuario();
	$html="";
	$html .= listaActoresDirectoresUser($Usuario->user(), null, 1);
        
	return $html;
}


$contenidoPrincipal.= mostrarDirectoresFavoritos();


require __DIR__ . '/includes/plantillas/plantilla.php';