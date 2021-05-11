<?php

require_once __DIR__.'/includes/config.php';

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$peliculas = new es\ucm\fdi\aw\peliculas();
$pelicula = $peliculas->getPeliculaPorId($id);

$tituloPagina = $pelicula->title();

$href = '';
if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
    $href .= "<a href=\"./nuevaReview.php?id={$pelicula->id()}\">Escribir nueva review</a>";
}

$contenidoPrincipal=<<<EOS
	<div class="pagina-pelicula">
    <img id="imagen-pelicula" src="img/peliculas/{$pelicula->image()}" alt="pelicula" width="200" height="300">
    <div>
    <p> Título: {$pelicula->title()}</p>
    <p> Fecha de estreno: {$pelicula->date_released()} </p>
    <p> Duración: {$pelicula->duration()} minutos </p>
    <p> País: {$pelicula->country()} </p>
    <p> Puntuación: {$pelicula->rating()}/5 </p>
    <p> Sinopsis: {$pelicula->plot()} </p>
    </div>
    </div>
    {$peliculas->listaPlataformas($pelicula->plataformas())}
    {$peliculas->listaActoresDirectores($pelicula->actors(), 0)}
    {$peliculas->listaActoresDirectores($pelicula->directors(), 1)}
    {$peliculas->listaReviews($pelicula->reviews(), $href)}
    
EOS;

require __DIR__ . '/includes/plantillas/plantilla.php';