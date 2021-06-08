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

if(array_key_exists('addActorDirectorFav', $_POST)) {
    addActorDirectorFav($id, $app->user());
    header("Refresh:0");
} else if(array_key_exists('delActorDirectorFav', $_POST)) {
    delActorDirectorFav($id, $app->user());
    header("Refresh:0");
}
$actorDirectorFav = '';
if ($app->usuarioLogueado()) {
    if (isActorDirectorFav($id, $app->user())) {
        $actorDirectorFav = '<form method="post">
            <input type="submit" name="delActorDirectorFav" class="button" value="Eliminar de Favoritos"/>
            </form>';
    } else {
        $actorDirectorFav = '<form method="post">
            <input type="submit" name="addActorDirectorFav" class="button" value="Añadir a Favoritos"/>
            </form>';
    }
}

$contenidoPrincipal = '';

$prevLink = urlencode($_SERVER['REQUEST_URI']);
if ($app->usuarioLogueado() && ($app->esGestor() || $app->esAdmin())) {
    $contenidoPrincipal .=<<<EOS
        <a href="./editarActorDirector.php?id={$actorDirector->id()}&prevPage={$prevLink}">Editar</a>
        <a href="./eliminarActorDirector.php?id={$actorDirector->id()}&prevPage={$prevLink}">Eliminar</a>
    EOS;
}

$tituloPagina = $actorDirector->name();
$href = '';
$contenidoPrincipal.=<<<EOS
	<div class="pagina-pelicula">
    <img id="imagen-actordirector" src="img/actores_directores/{$actorDirector->image()}" alt="{$actorDirector->name()}" >
    <div>
	<h3> {$adString}</h3>
    <p> Nombre: {$actorDirector->name()}</p>
    <p> Fecha de nacimiento: {$actorDirector->birth_date()} </p>
    <p> Nacionalidad: {$actorDirector->nationality()} </p>
    <p> Descripción: {$actorDirector->description()} </p>
    $actorDirectorFav
    </div>
    </div>
    $peliculas
EOS;

require __DIR__ . '/includes/plantillas/plantilla.php';
