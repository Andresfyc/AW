<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/usuarios_utils.php';
require_once __DIR__.'/includes/comun/peliculas_utils.php';

function mostrarPerfil() {
    $RUTA_APP = RUTA_APP;
    $divUsuario = getDivUsuario();
    $Usuario = getUsuario();
    $html=<<<EOS
        <h1> Tú perfil</h1>
        $divUsuario
        <p><a href="actoresFavoritos.php?id={$Usuario->user()}">Ver tus actores favoritos</a></p>
        <p><a href="directoresFavoritos.php?id={$Usuario->user()}">Ver tus directores favoritos</a></p>
        <p><a href="swappers.php?id={$Usuario->user()}">Ver todos los swappers a los que sigues</a></p>
        <p><a href="reviews.php?id={$Usuario->user()}"> Ver todas tus reviews de películas </a></p>
    EOS;
    return $html;
}

function mostrarPeliculas() {
    $RUTA_APP = RUTA_APP;
    $Usuario = getUsuario();
	
    return mostrarPeliculasFav($Usuario->user(), 7);
  
}


$perfilInicial = mostrarPerfil();
$peliculasFav = mostrarPeliculas();


$tituloPagina = 'Usuario';

$contenidoPrincipal =<<<EOS
    $perfilInicial
	$peliculasFav

	
	
EOS;

require __DIR__ . '/includes/plantillas/plantilla.php';