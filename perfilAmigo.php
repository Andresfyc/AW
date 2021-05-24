<?php
/*
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/usuarios_utils.php';
require_once __DIR__.'/includes/comun/peliculas_utils.php';

//$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$usuario = getUsuarioPorUser($id);

function mostrarPerfilAmigo() {
    $RUTA_APP = RUTA_APP;

    $divUsuario = getDivUsuario();
    $html=<<<EOS
        <h1> Perfil de usuario</h1>
        $divUsuario
        <p><a href="{$RUTA_APP}reviews.php">Ver todas tus reviews de películas</a></p>
        <p><a href="actoresFavoritos.php">Ver tus actores favoritos</a></p>
        <p><a href="directoresFavoritos.php">Ver tus directores favoritos</a></p>
        <p><a href="swappers.php">Ver todos los swappers a los que sigues</a></p>
    EOS;
    return $html;
}

function mostrarPeliculas() {
    $RUTA_APP = RUTA_APP;
	
    return mostrarPeliculasFav($usuario->user(), 7);
  
}


$perfilInicial = mostrarPerfilAmigo();
$peliculasFav = mostrarPeliculas();


$tituloPagina = 'Usuario';

$contenidoPrincipal =<<<EOS
    $perfilInicial
	$peliculasFav
    

	
	
EOS;

require __DIR__ . '/includes/plantillas/plantilla.php';

*/