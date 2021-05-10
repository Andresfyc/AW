<?php

require_once __DIR__.'/includes/config.php';

$busqueda = htmlspecialchars(trim(strip_tags($_POST["buscar"])));

$usuarios = new es\ucm\fdi\aw\usuarios();
$peliculas = new es\ucm\fdi\aw\peliculas();
$actoresDirectores = new es\ucm\fdi\aw\actoresDirectores();

$tituloPagina = "Búsqueda";

$contenidoPrincipal=<<<EOS
    <h1> Búsqueda: {$busqueda} </h1>
    {$usuarios->busqueda($busqueda)}
    {$peliculas->busqueda($busqueda)}
    {$actoresDirectores->busqueda($busqueda)}
EOS;

require __DIR__ . '/includes/plantillas/plantilla.php';