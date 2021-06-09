<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/usuarios_utils.php';

$tituloPagina = 'Actores/Directores Favoritos';

function mostrarActoresDirectoresFavoritos() {
	$userIn = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
	$ad = filter_input(INPUT_GET, 'ad', FILTER_SANITIZE_NUMBER_INT);

	$actorDirector = $ad ? "Directores" : "Actores";
	
	$html = '<h1>'.$actorDirector .' Favoritos </h1>';
	$html .= listaActoresDirectoresUser($userIn, null, $ad);
        
	return $html;
}

$contenidoPrincipal = mostrarActoresDirectoresFavoritos();


require __DIR__ . '/includes/plantillas/plantilla.php';