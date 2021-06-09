<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/peliculas_utils.php';

use es\ucm\fdi\aw\Aplicacion;

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$app = Aplicacion::getSingleton();

$pelicula = buscaPeliculaPorId($id);

$tituloPagina = $pelicula->title();
$prevLink = urlencode($_SERVER['REQUEST_URI']);

$href = '';
if ($app->usuarioLogueado()) {
	$href .= '<a href="nuevaReview.php?id='.$pelicula->id().'&prevPage='.$prevLink.'">Escribir nueva review</a>';
}

$plataformas = listaPlataformas($pelicula->plataformas(),$pelicula->peliculasPlataformas());
$actores = listaActoresDirectores($pelicula->actors(), 0);
$directores = listaActoresDirectores($pelicula->directors(), 1);
$reviews = listaReviews($pelicula->reviews());
$generos = listaGeneros($pelicula->genres());

$contenidoPrincipal = '';

$prevLink = urlencode($_SERVER['REQUEST_URI']);
if ($app->usuarioLogueado() && ($app->esGestor() || $app->esAdmin())) {
	$contenidoPrincipal .=<<<EOS
		<a href="./editarPelicula.php?id={$pelicula->id()}&prevPage={$prevLink}">Editar</a>
		<a href="./eliminarPelicula.php?id={$pelicula->id()}&prevPage={$prevLink}">Eliminar</a>
	EOS;
}

if(array_key_exists('addListaVer', $_POST)) {
	addListaVer($id, $app->user());
	header("Refresh:0");
} else if(array_key_exists('delListaVer', $_POST)) {
	delListaVer($id, $app->user());
	header("Refresh:0");
}
$peliculaLista = '';
if ($app->usuarioLogueado()) {
	if (isPeliculaEnLista($id, $app->user())) {
		$peliculaLista = '<form method="post">
			<input type="submit" name="delListaVer" class="button" value="Eliminar de Ver más tarde"/>
			</form>';
	} else {
		$peliculaLista = '<form method="post">
			<input type="submit" name="addListaVer" class="button" value="Añadir a Ver más tarde"/>
			</form>';
	}
}

$comprarVer = '';
if ($pelicula->link() && $pelicula->price()){
	if ($app->esPremium() || (isPeliculaCompradaPorUsuario($app->user(), $pelicula->id()))) {
		$comprarVer .= '<a class="comprar-peli" href="visualizador.php?id='.$pelicula->id().'"><i class="fa fa-television" ></i> Ver Película </a>';
	} else if ($app->usuarioLogueado()) {
		$comprarVer .= '<a class="comprar-peli" href="carrito.php?id='.$pelicula->id().'&tipo=pelicula"><i class="fa fa-paypal" ></i> Comprar ('.$pelicula->price().') </a>';
	}
}

$contenidoPrincipal.=<<<EOS
    <div class="pagina-pelicula">
	<div class="div-pelicula-imagen">
    <img id="imagen-pelicula" src="img/peliculas/{$pelicula->image()}" alt="{$pelicula->title()}" >
	$comprarVer
	</div>
    <div>
    <p> Título: {$pelicula->title()}</p>
    <p> Fecha de estreno: {$pelicula->date_released()} </p>
    <p> Duración: {$pelicula->duration()} minutos </p>
    <p> País: {$pelicula->country()} </p>
	<p> Géneros:
	$generos
    </p><p> Puntuación: {$pelicula->rating()}/5 </p>
    <p> Sinopsis: {$pelicula->plot()} </p>
    $peliculaLista
    </div>
    </div>
    $plataformas
    $actores
    $directores
    <h3> Reviews: {$href}</h3>
    $reviews
    
EOS;

require __DIR__ . '/includes/plantillas/plantilla.php';