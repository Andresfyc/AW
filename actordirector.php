<?php

require_once __DIR__.'/includes/config.php';

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$ad=new es\ucm\fdi\aw\actoresDirectores();
$actordirector=$ad->getADPorId($id);
$num_id=$actordirector->actor_director();
$peliculas = new es\ucm\fdi\aw\peliculas();
$pelicula = $peliculas->getBuscaActorPorId($id);
if($num_id==0){
	$num_id="Actor";
}else{
	$num_id="Director";
}
$tituloPagina = $actordirector->name();
$href = '';
$contenidoPrincipal=<<<EOS
	<div class="pagina-pelicula">
    <img id="imagen-actordirector" src="img/actores_directores/{$actordirector->image()}" alt="pelicula" width="200" height="300">
    <div>
	<h3> {$num_id}</h3>
    <p> Nombre: {$actordirector->name()}</p>
    <p> Fecha de nacimiento: {$actordirector->birth_date()} </p>
    <p> Nacionalidad: {$actordirector->nationality()} </p>
    <p> Descripción: {$actordirector->description()} </p>
    <p> </p>
	<center>
	{$peliculas->listaPelis_ActorDirector($pelicula)}
	</center>
    </div>
    </div>
	
    
    
    
EOS;

require __DIR__ . '/includes/plantillas/plantilla.php';
