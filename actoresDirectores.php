<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/peliculas_utils.php';

$tituloPagina = 'Actores y Directores';
$contenidoPrincipal='<h1>Actores y Directores</h1>';

function mostrarLActoresDirectores() {

	$html= listadoActoresDirectores();
        
	return $html;
}

$contenidoPrincipal.= mostrarLActoresDirectores();


require __DIR__ . '/includes/plantillas/plantilla.php';