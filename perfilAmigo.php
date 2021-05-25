<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/usuarios_utils.php';
require_once __DIR__.'/includes/comun/peliculas_utils.php';


function mostrarPerfilAmigo() {
    $RUTA_APP = RUTA_APP;
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
    $Usuario = getUsuarioPorUser($id);
    $divUsuario = getDivAmigo($Usuario);
    $html=<<<EOS
    <h1> Perfil de {$Usuario->user()}</h1>
        $divUsuario
        <p><a href="actoresFavoritos.php?id={$Usuario->user()}">Ver sus actores favoritos</a></p>
        <p><a href="directoresFavoritos.php?id={$Usuario->user()}">Ver sus directores favoritos</a></p>
        <p><a href="swappers.php?id={$Usuario->user()}">Ver todos los swappers a los que sigue</a></p>
        <p><a href="reviews.php?id={$Usuario->user()}"> Ver todas sus reviews de películas </a></p>
    EOS;
    return $html;
}

function mostrarPeliculas() {
    $RUTA_APP = RUTA_APP;
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
    $Usuario = getUsuarioPorUser($id);
    return mostrarPeliculasFav($Usuario->user(), 7);
  
}


$perfilInicial = mostrarPerfilAmigo();
$peliculasFav = mostrarPeliculas();


$tituloPagina = 'Usuario';

$contenidoPrincipal =<<<EOS
    $perfilInicial
	$peliculasFav
EOS;

require __DIR__ . '/includes/plantillas/plantilla.php';

