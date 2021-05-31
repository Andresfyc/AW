<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/usuarios_utils.php';
require_once __DIR__.'/includes/comun/peliculas_utils.php';

use es\ucm\fdi\aw\Aplicacion;

$userIn = filter_input(INPUT_GET, 'user', FILTER_SANITIZE_STRING);

function mostrarPerfil($user, $isSelf) {
    $divUsuario = getDivUsuario($user, $isSelf);
    if ($isSelf) {
        $html=<<<EOS
            <h1> Tú perfil</h1>
            $divUsuario
            <p><a href="actoresFavoritos.php?id={$user}">Ver tus actores favoritos</a></p>
            <p><a href="directoresFavoritos.php?id={$user}">Ver tus directores favoritos</a></p>
            <p><a href="swappers.php?id={$user}">Ver todos los swappers a los que sigues</a></p>
            <p><a href="reviews.php?id={$user}"> Ver todas tus reviews de películas </a></p>
        EOS;
        return $html;
    } else {
        $html=<<<EOS
        <h1> Perfil de {$user}</h1>
            $divUsuario
            <p><a href="actoresFavoritos.php?id={$user}">Ver sus actores favoritos</a></p>
            <p><a href="directoresFavoritos.php?id={$user}">Ver sus directores favoritos</a></p>
            <p><a href="swappers.php?id={$user}">Ver todos los swappers a los que sigue</a></p>
            <p><a href="reviews.php?id={$user}"> Ver todas sus reviews de películas </a></p>
        EOS;
        return $html;
    }
}


if (strlen($userIn) < 1) {
    $app = Aplicacion::getSingleton();
    $user = $app->user();
    $isSelf = 1;
} else {
    $user = $userIn;
    $isSelf = 0;
}

$perfilInicial = mostrarPerfil($user, $isSelf);
$peliculasVer = mostrarPeliculasVer($user, 7);


$tituloPagina = 'Usuario';

$contenidoPrincipal =<<<EOS
    $perfilInicial
	$peliculasVer
EOS;

require __DIR__ . '/includes/plantillas/plantilla.php';