<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/peliculas_utils.php';

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$pelicula = buscaPeliculaPorId($id);

$tituloPagina = $pelicula->title();

$href = '';
if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
    $href .= '<a href="nuevaReview.php?id='.$pelicula->id().'">Escribir nueva review</a>';
}

$plataformas = listaPlataformas($pelicula->plataformas(),$pelicula->peliculasPlataformas());
$actores = listaActoresDirectores($pelicula->actors(), 0);
$directores = listaActoresDirectores($pelicula->directors(), 1);
$reviews = listaReviews($pelicula->reviews());

$contenidoPrincipal=<<<EOS
	<div class="pagina-pelicula">
    <img id="imagen-pelicula" src="img/peliculas/{$pelicula->image()}" alt="pelicula" >
    <div>
    <p> Título: {$pelicula->title()}</p>
    <p> Fecha de estreno: {$pelicula->date_released()} </p>
    <p> Duración: {$pelicula->duration()} minutos </p>
    <p> País: {$pelicula->country()} </p>
    <p> Puntuación: {$pelicula->rating()}/5 </p>
    <p> Sinopsis: {$pelicula->plot()} </p>
    </div>
    </div>
    $plataformas
    $actores
    $directores
    <h3> Reviews: {$href}</h3>
    $reviews
    
EOS;

require __DIR__ . '/includes/plantillas/plantilla.php';