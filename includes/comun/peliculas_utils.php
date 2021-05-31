<?php

use es\ucm\fdi\aw\actoresDirectores\ActorDirector;
use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\peliculas\Pelicula;
use es\ucm\fdi\aw\plataformas\Plataforma;
use es\ucm\fdi\aw\plataformas\PeliculaPlataforma;
use es\ucm\fdi\aw\reviews\Review;

/*
 * Funciones de apoyo
 */

function listaPelis_ActorDirector($id){
    $peliculas = Pelicula::peliculasPorActorDirectorId($id);
    $html = '';
    if (!empty($peliculas)) {
        $html= "<h3> Películas: </h3>";
        $html .= '<div class="div-actoresDirectoresPeli">';
        foreach($peliculas as $pelicula) {
            $text = $pelicula->title();
            $text = strlen($text) > 25 ? substr($text, 0, 25).'...' : $text;
            $html.=<<<EOS
                <div class="div-actorDirectorPeli">
                <img id="imagen-actorDirector" src="img/peliculas/{$pelicula->image()}" alt="imagen" >
                <p><a href="./pelicula.php?id={$pelicula->id()}">{$text}</a></p>
            EOS;
            $html .= '</div>';
        }
    }
    return $html;
}

function mostrarPortadaPeliculas($limit=NULL) {
    $ultimasPeliculasEstrenadas = listaPeliculas('date_released', 0, $limit);
    $listaUltimasPeliculasAnadidas = listaPeliculas('id', 0, $limit);

    $html=<<<EOS
        <h1>Página principal</h1>
        <h3> Estrenos recientes </h3>
        $ultimasPeliculasEstrenadas
        <h3> Últimas películas añadidas </h3>
        $listaUltimasPeliculasAnadidas
    EOS;

    return $html;
}
function mostrarPeliculasVer($user, $limit=NULL) {
    $peliculasVer= listaPeliculasVer($user, $limit);

    $html=<<<EOS
        <h3> Ver más tarde: </h3>
        $peliculasVer
    EOS;

    return $html;
}

function getDivPeliculas($peliculas, $limit=NULL) {
	$app = Aplicacion::getSingleton();
    $html = '<div class="div-peliculas">';
    foreach($peliculas as $pelicula) {
        $html .= '<div class="div-pelicula">';
        if ($limit == NULL && $app->usuarioLogueado() && ($app->esGestor() || $app->esAdmin())) {
            $html .=<<<EOS
                <p><a href="./editarPelicula.php?id={$pelicula->id()}&prevPage=peliculas">Editar</a></p>
                <p><a href="./eliminarPelicula.php?id={$pelicula->id()}&prevPage=peliculas">Eliminar</a></p>
                <img id="film_pic_small" src="img/peliculas/{$pelicula->image()}" alt="imagen" >
            EOS;
        } else {
            $html .=<<<EOS
                <img id="film_pic" src="img/peliculas/{$pelicula->image()}" alt="imagen" >
            EOS;
        }
        $text = $pelicula->title();
        $text = strlen($text) > 40 ? substr($text, 0, 40).'...' : $text;
        $html .=<<<EOS
            <p><a href="./pelicula.php?id={$pelicula->id()}">{$text}</a></p>
            </div>
        EOS;
    }

    if ($limit != NULL && count($peliculas) > 1) {
        $html .=<<<EOS
            <div class="div-pelicula-last">
            <p><a href="./peliculas.php">Ver todas</a></p>
            </div>
        EOS;
    }
    $html .= '</div>';

    return $html;
}


function listaActoresDirectores($actoresDirectores, $ad)
{
    $html = '';
    if (!empty($actoresDirectores)) {
        if (!$ad){
            $html .= '<h3> Actores: </h3>';
        } else {
            $html .= '<h3> Directores: </h3>';
        }
        $html .= '<div class="div-actoresDirectoresPeli">';
        foreach($actoresDirectores as $actorDirector) {
            $text = $actorDirector->name();
            $text = strlen($text) > 25 ? substr($text, 0, 25).'...' : $text;
            $html.=<<<EOS
                <div class="div-actorDirectorPeli">
                <img id="film_pic" src="img/actores_directores/{$actorDirector->image()}" alt="imagen" >
                <p><a href="./actorDirector.php?id={$actorDirector->id()}">{$text}</a></p>
                </div>
            EOS;
        }
        $html .= '</div>';
    }

    return $html;
}

function listaPlataformas($plataformas,$peliculasPlataformas){
    $html = '';
    if (!empty($plataformas)) {
        $html .= '<h3> Plataformas: </h3>';
        $html .= '<div class="div-plataformas-peli">';
        foreach($peliculasPlataformas as $peliplata) {
            $plataforma = Plataforma::buscaPorId($peliplata->platform_id());
            $html.=<<<EOS
                <div class="div-plataformas-peli">
                <a href={$peliplata->link()}><img id="platf_pic" src="img/plataformas/{$plataforma->image()}" alt="imagen" ></a>
                </div>
            EOS;
        }
        $html .= '</div>';
    }

    return $html;
}
function listaReviews($reviews)
{
	$app = Aplicacion::getSingleton();
    $html = '';
    if (!empty($reviews)) {
        
        $html .= '<div>';
        foreach($reviews as $review) {
            $html .= '<div class="div-reviewsPeli">';
            $html .= '<div>';
            $html .= "<p>Puntuación: {$review->stars()}/5</p>";
            $html .= "<p>{$review->time_created()}</p>";
            $html .= "<p>{$review->user()}</p><p>";
            if ($app->usuarioLogueado() && ($app->esModerador() || $app->esAdmin() || $review->user() == $app->user())) {
                $html .= "<a href=\"./editarReview.php?id={$review->id()}\">Editar</a>";
                $html .= "<a href=\"./eliminarReview.php?id={$review->id()}\"> Eliminar</a>";
            }
            $html .= '</p></div>';
            $html .= "<p>{$review->review()}</p>";
            $html .= '</div>';
        }
        $html .= '</div>';
    }

    return $html;
}

function busquedaActoresDirectores($search)
{
    $actoresDirectores = ActorDirector::busqueda($search);
    $html = '';
    if (!empty($actoresDirectores)) {
        $html .= '<h3> Actores y Directores: </h3>';
        $html .= '<ul>';
        foreach($actoresDirectores as $actorDirector) {
            $text = substr($actorDirector->birth_date(), 0, 4);
            $html .= "<p><a href=\"./actorDirector.php?id={$actorDirector->id()}\">{$actorDirector->name()} ({$text})</a></p>";
        }
        $html .= '</ul>';
    }

    return $html;
}

function busquedaPeliculas($search)
{
    $peliculas = Pelicula::busqueda($search);
    $html = '';
    if (!empty($peliculas)) {
        $html .= '<h3> Películas: </h3>';
        $html .= '<ul>';
        foreach($peliculas as $pelicula) {
            $text = substr($pelicula->date_released(), 0, 4);
            $html .= "<p><a href=\"./pelicula.php?id={$pelicula->id()}\">{$pelicula->title()} ({$text})</a></p>";
        }
        $html .= '</ul>';
    }

    return $html;
}

function listaPeliculas($order, $ascdesc, $limit=NULL)
{
    $peliculas = Pelicula::listaPeliculas($order, $ascdesc, $limit);

    return getDivPeliculas($peliculas, $limit);
}

function listaPeliculasVer($user, $limit=NULL)
{
    $peliculas = Pelicula::listaPeliculasVer($user, $limit);

    return getDivPeliculas($peliculas, $limit);
}

function buscaPeliculaPorId($id)
{
    return Pelicula::buscaPorId($id);
}

function buscaPeliculaPlataformaPorId($id)
{
    return PeliculaPlataforma::buscaPorId($id);
}

function buscaActorDirectorPorId($id)
{
    return ActorDirector::buscaPorId($id);
}

function eliminarPeliculaPorId($id)
{
    return Pelicula::borraPorId($id);
}

function eliminarPeliculaPlataformaPorId($id)
{
    return PeliculaPlataforma::borraPorId($id);
}
    
function getReviewPorId($id)
{
    return Review::buscaPorId($id);
}

function eliminarReviewPorId($id)
{
    return Review::borraPorId($id);
}
function getReviewPorIdPelicula($id)
{
    return Review::buscaReviewsPorIdPeli($id);
}

function isPeliculaEnLista($id, $user) 
{
    return Pelicula::isPeliculaEnLista($id, $user);
}

function addListaVer($id, $user)
{
    Pelicula::addListaVer($id, $user);
}

function delListaVer($id, $user)
{
    Pelicula::delListaVer($id, $user);
}

