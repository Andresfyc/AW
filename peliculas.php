<?php

require_once __DIR__.'/includes/config.php';

function mostrarPeliculas() {
	$peliculas = new es\ucm\fdi\aw\peliculas();
	$result = "<h1>Películas</h1>";
	$result .= $peliculas->listaPeliculas();	
	/*if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
	} else {
	}*/
	return $result;
}

$tituloPagina = 'Películas';

$contenidoPrincipal=mostrarPeliculas();

require __DIR__ . '/includes/plantillas/plantilla.php';