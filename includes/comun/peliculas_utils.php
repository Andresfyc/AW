<?php

use es\ucm\fdi\aw\actoresDirectores\ActorDirector;
use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\peliculas\Pelicula;
use es\ucm\fdi\aw\plataformas\Plataforma;
use es\ucm\fdi\aw\plataformas\PeliculaPlataforma;
use es\ucm\fdi\aw\reviews\Review;
use es\ucm\fdi\aw\generos\Genero;

/*
 * Funciones de apoyo
 */

function listaPelis_ActorDirector($order, $ascdesc, $id){
    $peliculas = Pelicula::peliculasPorActorDirectorId($order, $ascdesc, $id);
    $html = '';
    if (!empty($peliculas)) {
        $html= "<h3> Películas: </h3>";
        $html .= '<div class="div-actoresDirectoresPeli">';
        foreach($peliculas as $pelicula) {
            $text = $pelicula->title();
            $text = strlen($text) > 25 ? substr($text, 0, 25).'...' : $text;
            $html.=<<<EOS
                <div class="div-actorDirectorPeli">
                <img id="imagen-actorDirector" src="img/peliculas/{$pelicula->image()}" alt="{$pelicula->title()}" >
                <p><a href="./pelicula.php?id={$pelicula->id()}">{$text}</a></p>
            EOS;
            $html .= '</div>';
        }
    }
    return $html;
}

function mostrarPortadaPeliculas($limit=NULL) {
	$app = Aplicacion::getSingleton();
	
	$user = $app->user();
	
    $ultimasPeliculasEstrenadas = listaPeliculas('date_released', 'desc', $limit, null, null);
    $listaUltimasPeliculasAnadidas = listaPeliculas('id', 'desc', $limit, null, null);
	$peliculasLiked = Pelicula::ultimaPeliculaWatchedMejorRating($user, 1);
	$peliculasWatched = Pelicula::ultimaPeliculaWatched($user, 1);
    $actoresDirectores = ActorDirector::buscaActoresDirectoresPorUser($user);

    $html=<<<EOS
        <h1>Página principal</h1>
    EOS;

    $aux = "";
    $aux2 = "";

	 if($app->usuarioLogueado()){
        if ($peliculasLiked) {
            foreach($peliculasLiked as $peli1){
                if ($peli1->genres()) {
                    $aux = listaPeliculasGen2('rating', 'DESC', $peli1->genres(), $limit);
                }
            }
            $html .= "<h3> Porque te ha gustado {$peli1->title()}</h3>{$aux}";
        }
        if ($peliculasWatched) {
            foreach($peliculasWatched as $peli2){
                if ($peli2->genres()) {
                    $aux3 = listaPeliculasGen2('rating', 'DESC', $peli2->genres(), $limit);
                }
            }
            $html .= "<h3> Porque has visto {$peli2->title()}</h3>{$aux3}";
        }
        $aux2 = listadoPelisActoresDirectores2('title',null,$actoresDirectores,$limit);
        if($aux2!=null) {
            $html .="<h3> Peliculas de tus actores y directores favoritos</h3>{$aux2}";
        }
    }
     
    $html.=<<<EOS
        <h3> Estrenos recientes </h3>
        $ultimasPeliculasEstrenadas
        <h3> Últimas películas añadidas </h3>
        $listaUltimasPeliculasAnadidas
    
    EOS;



	
    return $html;
}

function mostrarPeliculasVer($user, $limit=NULL) {
    $peliculasVer= listaPeliculasVer('title',null,$user, $limit);

    $html=<<<EOS
        <h3> Ver más tarde: </h3>
        $peliculasVer
    EOS;

    return $html;
}

function mostrarPeliculasCompradas($user, $limit=NULL) {
    $peliculasCompradas= listaPeliculasCompradas('title',null,$user, $limit);

    $html=<<<EOS
        <h3> Peliculas compradas: </h3>
        $peliculasCompradas
    EOS;

    return $html;
}

function mostrarPeliculasGen($id, $limit=NULL) {
    $peliculasGen= listaPeliculasGen('id', 0, $id, $limit);

    $html=<<<EOS
        <h3> Ver más tarde: </h3>
        $peliculasGen
    EOS;

    return $html;
}


function getDivPeliculas($peliculas, $limit=NULL, $table, $value, $order=null, $ascdesc=null) {
	$app = Aplicacion::getSingleton();
    $html = '<div class="div-peliculas">';
    $prevLink = urlencode($_SERVER['REQUEST_URI']);
    foreach($peliculas as $pelicula) {
        $html .= '<div class="div-pelicula">';
        if ($limit == NULL && $app->usuarioLogueado() && ($app->esGestor() || $app->esAdmin())) {
            $html .=<<<EOS
                <p><a href="./editarPelicula.php?id={$pelicula->id()}&prevPage={$prevLink}">Editar</a></p>
                <p><a href="./eliminarPelicula.php?id={$pelicula->id()}&prevPage={$prevLink}">Eliminar</a></p>
                <img id="film_pic_small" src="img/peliculas/{$pelicula->image()}" alt="{$pelicula->title()}" >
            EOS;
        } else {
            $html .=<<<EOS
                <img id="film_pic" src="img/peliculas/{$pelicula->image()}" alt="{$pelicula->title()}" >
            EOS;
        }
        $text = $pelicula->title();
        $text = strlen($text) > 40 ? substr($text, 0, 40).'...' : $text;
        $html .=<<<EOS
            <p><a href="./pelicula.php?id={$pelicula->id()}">{$text}</a></p>
            </div>
        EOS;
    }

    if ($limit != NULL && count($peliculas) > 0) {
        $html .=<<<EOS
            <div class="div-pelicula-last">
            <p><a href="./peliculas.php?table={$table}&value={$value}&order={$order}&ascdesc={$ascdesc}">Ver todas</a></p>
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
                <img id="film_pic" src="img/actores_directores/{$actorDirector->image()}" alt="{$actorDirector->name()}" >
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
                <a href={$peliplata->link()}><img id="platf_pic" src="img/plataformas/{$plataforma->image()}" alt="{$plataforma->name()}" ></a>
                </div>
            EOS;
        }
        $html .= '</div>';
    }

    return $html;
}

function listaGeneros($genres){
    $html = '';
    if (!empty($genres)) {
        $html .= '|';
        foreach($genres as $genre) {
            $text = $genre->name();
            $table = 'genre';

            $html.=<<<EOS
                <a href="./peliculas.php?table={$table}&value={$genre->id()}"> $text </a> |
            EOS;
        }
    }
    return $html;
}
function listaReviews($reviews)
{
	$app = Aplicacion::getSingleton();
    $html = '';
    if (!empty($reviews)) {
        
        $html .= '<div>';
        $prevLink = urlencode($_SERVER['REQUEST_URI']);
        foreach($reviews as $review) {
            $html .= '<div class="div-reviewsPeli">';
            $html .= '<div>';
            $html .= "<p>Puntuación: {$review->stars()}/5</p>";
            $html .= "<p>{$review->time_created()}</p>";
            $html .= "<p>{$review->user()}</p><p>";
            if ($app->usuarioLogueado() && ($app->esModerador() || $app->esAdmin() || $review->user() == $app->user())) {
                $html .= "<a href=\"./editarReview.php?id={$review->id()}&prevPage={$prevLink}\">Editar</a>";
                $html .= "<a href=\"./eliminarReview.php?id={$review->id()}&prevPage={$prevLink}\"> Eliminar</a>";
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

function listadoGeneros()
{
	$app = Aplicacion::getSingleton();
    $prevLink = urlencode($_SERVER['REQUEST_URI']);
    $html = '<a href="'.RUTA_APP.'nuevoGenero.php?prevPage='.$prevLink.'">Añadir género</a>';
    $generos = Genero::listaGeneros();
    foreach($generos as $genero) {
    
        $html .= '<div class="row-item">';
        $html .= "<p>{$genero->name()} ";
        if ($app->usuarioLogueado() && ($app->esAdmin() || $app->esGestor())) {
            $html .= '<a href="'.RUTA_APP.'editarGenero.php?id='.$genero->id().'&prevPage='.$prevLink.'">Editar</a>';
            $html .= '<a href="'.RUTA_APP.'eliminarGenero.php?id='.$genero->id().'&prevPage='.$prevLink.'"> Eliminar</a>';
        }
        $html .= '</p></div>';
    }

    return $html;
}

function listadoPlataformas()
{
	$app = Aplicacion::getSingleton();
    $prevLink = urlencode($_SERVER['REQUEST_URI']);
    $html = '<a href="'.RUTA_APP.'nuevaPlataforma.php?prevPage='.$prevLink.'">Añadir plataforma</a>';
    $plataformas = Plataforma::listaPlataformas();
    foreach($plataformas as $plataforma) {
    
        $html .= '<div class="row-item">';
        $html .= "<p>{$plataforma->name()} ";
        if ($app->usuarioLogueado() && ($app->esAdmin() || $app->esGestor())) {
            $html .= '<a href="'.RUTA_APP.'editarPlataforma.php?id='.$plataforma->id().'&prevPage='.$prevLink.'">Editar</a>';
            $html .= '<a href="'.RUTA_APP.'eliminarPlataforma.php?id='.$plataforma->id().'&prevPage='.$prevLink.'"> Eliminar</a>';
        }
        $html .= '</p></div>';
    }

    return $html;
}

function listadoActoresDirectores()
{
	$app = Aplicacion::getSingleton();
    $prevLink = urlencode($_SERVER['REQUEST_URI']);
    $html = '<a href="'.RUTA_APP.'nuevoActorDirector.php?prevPage='.$prevLink.'">Añadir actor o director</a>';
    $actoresDirectores = ActorDirector::listaActoresDirectores();
    foreach($actoresDirectores as $actorDirector) {
    
        $html .= '<div class="row-item">';
        $html .= "<p>{$actorDirector->name()} ";
        if ($app->usuarioLogueado() && ($app->esAdmin() || $app->esGestor())) {
            $html .= '<a href="'.RUTA_APP.'editarActorDirector.php?id='.$actorDirector->id().'&prevPage='.$prevLink.'">Editar</a>';
            $html .= '<a href="'.RUTA_APP.'eliminarActorDirector.php?id='.$actorDirector->id().'&prevPage='.$prevLink.'"> Eliminar</a>';
        }
        $html .= '</p></div>';
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

function pagarPaypalPelicula($pelicula)
{
    $app = Aplicacion::getSingleton();
    $total = $pelicula->price();
    $user = $app->user();
    $productId = $pelicula->id();
    $RUTA_APP = RUTA_APP;

    $html = '<div id="paypal-button"></div>';


        $html .= <<<EOS
        
        <script>
            paypal.Button.render({
            // Configure environment
        env: 'sandbox',
        client: {
        sandbox: 'ARQl_tpu0jLSamyry95i9aHyXWF3O6byxfEfrUq_KGHVHNp9othxvOYoPSQcDXOm2sDHwrJWH450V405',
        production: 'demo_production_client_id'
        },
        // Customize button (optional)
        locale: 'es_ES',
        style: {
            size: 'small',
            color: 'gold',
            shape: 'pill',
        },

           // Enable Pay Now checkout flow (optional)
        commit: true,

        // Set up a payment
        payment: function(data, actions) {
          return actions.payment.create({
            transactions: [{
              amount: {
                total: '$total',
                currency: 'EUR'
              },
            }]
          });
        },
        // Execute the payment
        onAuthorize: function(data, actions) {
          return actions.payment.execute().then(function() {
            // Show a confirmation message to the buyer
            window.location="{$RUTA_APP}verificador.php?paymentID="+data.paymentID+"&payerID="+data.payerID+"&token="+data.paymentToken+"&pid={$productId}&user={$user}";
            }); 
             } 
         }, "#paypal-button"); 
      </script> 
    EOS;

        return $html;

}

function getTodasPeliculas($order, $ascdesc, $limit=NULL)
{
    return Pelicula::listaPeliculas($order, $ascdesc, $limit);
}

function listadoPelisActoresDirectores($order, $ascdesc, $value, $limit=NULL)
{

    $peliculas = Pelicula::peliculasPorActorDirectorId($order, $ascdesc, $value);

    return getDivPeliculas($peliculas, $limit, 'actor', $value, $order, $ascdesc);
}

function listadoPelisActoresDirectores2($order, $ascdesc, $ads, $limit=NULL)
{

    $peliculas = Pelicula::peliculasPorActorDirectorId2($order, $ascdesc, $ads);

    return getDivPeliculas($peliculas, $limit, null, null, $order, $ascdesc);
}

function listaPeliculas($order, $ascdesc, $limit=NULL, $table, $value)
{
    $peliculas = Pelicula::listaPeliculas($order, $ascdesc, $limit);

    return getDivPeliculas($peliculas, $limit, $table, $value, $order, $ascdesc);
}

function listaPeliculasVer($order, $ascdesc, $user, $limit=NULL)
{
    $peliculas = Pelicula::listaPeliculasVer($order, $ascdesc ,$user, $limit);

    return getDivPeliculas($peliculas, $limit, 'ver_tarde' ,$user, $order, $ascdesc);
}

function listaPeliculasCompradas($order, $ascdesc, $user, $limit=NULL)
{
    $peliculas = Pelicula::listaPeliculasCompradas($order, $ascdesc ,$user, $limit);

    return getDivPeliculas($peliculas, $limit, 'ver_tarde' ,$user, $order, $ascdesc);
}

function listaPeliculasGen($order, $ascdesc, $id, $limit=NULL)
{
    $peliculas = Pelicula::listaPeliculasGen($order, $ascdesc, $id, $limit);
	
    return getDivPeliculas($peliculas, $limit, 'genre', $id, $order, $ascdesc);
}

function listaPeliculasGen2($order, $ascdesc, $genres, $limit=NULL)
{
    $peliculas = Pelicula::listaPeliculasGen2($order, $ascdesc, $genres, $limit);
	
    return getDivPeliculas($peliculas, $limit, null, null, $order, $ascdesc);
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

function getGeneroPorId($id)
{
    return Genero::buscaPorId($id);
}

function getActorDirectorPorId($id)
{
    return ActorDirector::buscaPorId($id);
}

function getPlataformaPorId($id)
{
    return Plataforma::buscaPorId($id);
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

function isActorDirectorFav($id, $user) 
{
    return ActorDirector::isActorDirectorFav($id, $user);
}

function addActorDirectorFav($id, $user) 
{
    ActorDirector::addActorDirectorFav($id, $user);
}

function delActorDirectorFav($id, $user) 
{
    ActorDirector::delActorDirectorFav($id, $user);
}

function existeReviewUsuarioPelicula($id, $user) 
{
    return Pelicula::existeReviewUsuarioPelicula($id, $user);
}

function eliminarGeneroPorId($id)
{
    return Genero::borraPorId($id);
}

function eliminarActorDirectorPorId($id)
{
    return ActorDirector::borraPorId($id);
}

function eliminarPlataformaPorId($id)
{
    return Plataforma::borraPorId($id);
}

function isPeliculaCompradaPorUsuario($user, $id)
{
    return Pelicula::isPeliculaCompradaPorUsuario($user,$id);
}

function generos()
{
    return Genero::listaGeneros();
}

function actores()
{
    return ActorDirector::actoresDirectores(0);
}

function directores()
{
    return ActorDirector::actoresDirectores(1);
}
