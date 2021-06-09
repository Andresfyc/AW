<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/peliculas_utils.php';

$tituloPagina = 'Ver Película';

function mostrarVisualizadorPelicula() {

	$filmId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
    $pelicula = buscaPeliculaPorId($filmId);
	$html = "<h1>{$pelicula->title()}</h1>";

	$html .= '<iframe class="video" allow="fullscreen;" src="'.$pelicula->link().'"></iframe>';
        
	return $html;
}

$contenidoPrincipal = mostrarVisualizadorPelicula();


require __DIR__ . '/includes/plantillas/plantilla.php';