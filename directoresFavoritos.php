<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/usuarios_utils.php';

use es\ucm\fdi\aw\Aplicacion;

$tituloPagina = 'Directores Favoritos';
$contenidoPrincipal='<h1>Directores Favoritos</h1>';

function mostrarDirectoresFavoritos() {
	$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
	$Usuario = getUsuarioPorUser($id);
	$html="";
	$html .= listaActoresDirectoresUser($Usuario->user(), null, 1);
        
	return $html;
}


$contenidoPrincipal.= mostrarDirectoresFavoritos();


require __DIR__ . '/includes/plantillas/plantilla.php';