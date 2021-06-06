<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/peliculas_utils.php';

$tituloPagina = 'Plataformas';
$contenidoPrincipal='<h1>Plataformas</h1>';

function mostrarPlataformas() {

	$html= listadoPlataformas();
        
	return $html;
}

$contenidoPrincipal.= mostrarPlataformas();


require __DIR__ . '/includes/plantillas/plantilla.php';