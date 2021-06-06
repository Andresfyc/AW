<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/peliculas_utils.php';

$tituloPagina = 'Géneros';
$contenidoPrincipal='<h1>Géneros</h1>';

function mostrarGeneros() {

	$html= listadoGeneros();
        
	return $html;
}

$contenidoPrincipal.= mostrarGeneros();


require __DIR__ . '/includes/plantillas/plantilla.php';