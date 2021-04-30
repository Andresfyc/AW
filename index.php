<?php

require_once __DIR__.'/includes/config.php';

function mostrarPortadaPeliculas() {
	$peliculas = new es\ucm\fdi\aw\peliculas();
	$result = "<h1>Página principal</h1>";
	$result .= "<h3> Estrenos recientes </h3>";
	$result .= $peliculas->listaUltimasPeliculasEstrenadas(7);	
	$result .= "<h3> Últimas películas añadidas </h3>";
	$result .= $peliculas->listaUltimasPeliculasAnadidas(7);	
	/*if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
	} else {
	}*/
	return $result;
}

$tituloPagina = 'Portada';

$contenidoPrincipal=mostrarPortadaPeliculas();

require __DIR__ . '/includes/plantillas/plantilla.php';