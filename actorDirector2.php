<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/peliculas_utils.php';

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$actorDirector = buscaActorDirectorPorId($id);

if($actorDirector->actor_director()){
	$adString="Actor";
}else{
	$adString="Director";
}

$peliculas = listaPelis_ActorDirector($id);

$tituloPagina = $actorDirector->name();
$href = '';
$contenidoPrincipal=<<<EOS
	<div class="pagina-pelicula">
    <img id="imagen-actordirector" src="img/actores_directores/{$actorDirector->image()}" alt="pelicula" >
    <div>
	<h3> {$adString}</h3>
    <p> Nombre: {$actorDirector->name()}</p>
    <p> Fecha de nacimiento: {$actorDirector->birth_date()} </p>
    <p> Nacionalidad: {$actorDirector->nationality()} </p>
    <p> Descripción: {$actorDirector->description()} </p>
    <p> </p>
    </div>
    </div>
    $peliculas
EOS;

require __DIR__ . '/includes/plantillas/plantilla.php';
