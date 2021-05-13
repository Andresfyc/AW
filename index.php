<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/peliculas_utils.php';

$tituloPagina = 'FilmSwap';

$portadaPeliculas = mostrarPortadaPeliculas(7);

$contenidoPrincipal = <<<EOS
    $portadaPeliculas
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';