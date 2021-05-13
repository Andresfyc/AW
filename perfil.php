<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/usuarios_utils.php';

function mostrarPerfil() {
    $divUsuario = getDivUsuario();
    $html=<<<EOS
        <h1> Perfil de usuario</h1>
        $divUsuario
        <p><a href="reviews.php">Ver todas tus reviews de películas</a></p>
        <p><a href="actores.php">Ver tus actores favoritos</a></p>
        <p><a href="directores.php">Ver tus directores favoritos</a></p>
        <p><a href="swappers.php">Ver todos los swappers a los que sigues</a></p>
    EOS;
    return $html;
}

$tituloPagina = 'Usuario';

$contenidoPrincipal=mostrarPerfil();

require __DIR__ . '/includes/plantillas/plantilla.php';