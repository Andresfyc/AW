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

function prueba() {
	$result = '<div class="div-peliculas">';
	$result .= '<div class="div-pelicula">';
	$result .= '<img id="prof_pic" src="img/film_default.jpg" alt="imagen" width="200" height="300">';
	$result .= '<p><a href="">Título de película y la ashdga sfahs fjhagsf ahs</a></p>';
	$result .= '</div>';
	$result .= '<div class="div-pelicula-last">';
	$result .= '<p><a href="">Ver todas</a></p>';
	$result .= '</div>';
	$result .= '</div>';
	return $result;
}

$tituloPagina = 'Portada';

$contenidoPrincipal=mostrarPortadaPeliculas();
//$contenidoPrincipal=prueba();

require __DIR__ . '/includes/plantillas/plantilla.php';