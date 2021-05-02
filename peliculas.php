<?php

require_once __DIR__.'/includes/config.php';

function mostrarPeliculas() {
	$peliculas = new es\ucm\fdi\aw\peliculas();
	$result = "<h1>Películas</h1>";	
	if (isset($_SESSION["login"]) && ($_SESSION["login"]===true) && ($_SESSION["esGestor"] == true || $_SESSION["esAdmin"] == true)) {
		$result .= '<a href="nuevaPelicula.php">Añadir película</a>';
	}
	$result .= $peliculas->listaPeliculas();
	return $result;
}

$tituloPagina = 'Películas';

$contenidoPrincipal=mostrarPeliculas();

require __DIR__ . '/includes/plantillas/plantilla.php';