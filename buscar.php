<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/peliculas_utils.php';
require_once __DIR__.'/includes/comun/usuarios_utils.php';

$busqueda = htmlspecialchars(trim(strip_tags($_POST["buscar"])));

$usuarios = busquedaUsuarios($busqueda);
$peliculas = busquedaPeliculas($busqueda);
$actoresDirectores = busquedaActoresDirectores($busqueda);

$tituloPagina = "Búsqueda";

$contenidoPrincipal=<<<EOS
    <h1> Búsqueda: {$busqueda} </h1>
    $usuarios
    $peliculas
    $actoresDirectores
EOS;

require __DIR__ . '/includes/plantillas/plantilla.php';