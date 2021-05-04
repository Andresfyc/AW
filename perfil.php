<?php

require_once __DIR__.'/includes/config.php';

function mostrarPerfil() {
    $usuario = new es\ucm\fdi\aw\usuarios();
    $result = "<h1> Perfil de usuario</h1>";
    $result .= $usuario->getDivUsuario();
    $result .= '<p><a href="reviews.php">Ver todas tus reviews de películas</a></p>';
    $result .= '<p><a href="actores.php">Ver tus actores favoritos</a></p>';
    $result .= '<p><a href="directores.php">Ver tus directores favoritos</a></p>';
    $result .= '<p><a href="swappers.php">Ver todos los swappers a los que sigues</a></p>';
    return $result;
}

$tituloPagina = 'Usuario';

$contenidoPrincipal=mostrarPerfil();

require __DIR__ . '/includes/plantillas/plantilla.php';