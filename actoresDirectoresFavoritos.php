<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/usuarios_utils.php';

$tituloPagina = 'Actores Favoritos';
$contenidoPrincipal='<h1>Actores Favoritos</h1>';

function mostrarActoresDirectoresFavoritos() {
	$userIn = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
	$ad = filter_input(INPUT_GET, 'ad', FILTER_SANITIZE_STRING);

	$html="";
	$html .= listaActoresDirectoresUser($userIn, null, $ad);
        
	return $html;
}

$contenidoPrincipal.= mostrarActoresDirectoresFavoritos();


require __DIR__ . '/includes/plantillas/plantilla.php';