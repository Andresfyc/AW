<?php

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\usuarios\Usuario;
use es\ucm\fdi\aw\actoresDirectores\ActorDirector;
use es\ucm\fdi\aw\reviews\Review;
use es\ucm\fdi\aw\peliculas\Pelicula;
use es\ucm\fdi\aw\notificaciones\Notificacion;

/*
 * Funciones de apoyo
 */

 
function getDivUsuario($user, $isSelf) {
    $RUTA_APP = RUTA_APP;
	$app = Aplicacion::getSingleton();
    $usuario = getUsuarioPorUser($user);  
    $prevLink = urlencode($_SERVER['REQUEST_URI']);  

    $perfil = '';
    $usuarioAmigo = '';
    if ($isSelf) {
        $perfil = '<p><a href="'.$RUTA_APP.'editarPerfil.php?id='.$usuario->user().'&prevPage='.$prevLink.'&isSelf=1">Editar Perfil</a></p>';
    } else {
        if(array_key_exists('addAmigo', $_POST)) {
            addAmigo($app->user(), $user);
            header("Refresh:0");
        } else if(array_key_exists('delAmigo', $_POST)) {
            delAmigo($app->user(), $user);
            header("Refresh:0");
        }
        if ($app->usuarioLogueado()) {
            if (isUsuarioAmigo($app->user(), $user)) {
                $usuarioAmigo = '<form method="post">
                    <input type="submit" name="delAmigo" class="button" value="Eliminar Swapper"/>
                    </form>';
            } else {
                $usuarioAmigo = '<form method="post">
                    <input type="submit" name="addAmigo" class="button" value="Añadir Swapper"/>
                    </form>';
            }
        }
    }

    if ($app->usuarioLogueado() || !$isSelf) {
        $html=<<<EOS
            <div class="div-perfil">
            <img id="film_pic" src="img/usuarios/{$usuario->image()}" alt="{$usuario->user()}" >
            <div>
            <p>Usuario: {$usuario->user()}</p>
            <p>Nombre completo: {$usuario->name()}</p>
            <p>Correo electrónico: </p>
            <p>Fecha de registro: {$usuario->date_joined()}</p>
            $perfil
            $usuarioAmigo
            </div>
            </div>
        EOS;
        return $html;
    }
}

if(array_key_exists('notify', $_POST)) {
    addNotificacion($_POST["user-notify"], $_POST["user-review"], $_POST["peliculaWatching"]);
    header("Refresh:0");
} else if (array_key_exists('no-notify', $_POST)) {
    delNotificacion($_POST["notification_id"]);
    header("Refresh:0");
}

function listaAmigos($user, $limit=NULL)
{
    $usuarios = Usuario::listaAmigos($user, $limit);
    $html = '<div>';
    foreach($usuarios as $usuario) {
        $peliculaWatching = $usuario->film();
        $watching = '';
        $swapper='<p><a href="usuario.php?id='.$usuario->user().'">'.$usuario->user().' </a></p>';
        if ($peliculaWatching) {
            $watching .= '<p><a href="'.RUTA_APP.'pelicula.php?id='.$peliculaWatching->id().'"> Viendo: '.$peliculaWatching->title().' </a> </p>';
            $notificacion = getNotificacion($user, $usuario->user(), $peliculaWatching->id());

            if ($notificacion) {
                $watching.= '<form method="post">
                <input type="hidden" name="notification_id" value="'.$notificacion->id().'" readonly/>
                <input type="submit" name="no-notify" class="button-notif" value="No Notificar"/>
                </form>';
            } else {
                $watching.= '<form method="post">
                <input type="hidden" name="user-review" value="'.$usuario->user().'" readonly/>
                <input type="hidden" name="user-notify" value="'.$user.'" readonly/>
                <input type="hidden" name="peliculaWatching" value="'.$peliculaWatching->id().'" readonly/>
                <input type="submit" name="notify" class="button-notif" value="Notificar"/>
                </form>';
            }
        }

        $html .=<<<EOS
            <div class="div-usuarios">
            <div class="div-usuarios">
            <div class="usuarios">
            <img id="prof_pic" src="img/usuarios/{$usuario->image()}" alt="{$usuario->user()}" >
            <div>
            $swapper
            <p>{$usuario->name()} </p>
            </div>
            </div>
            <div>
            $watching
            </div>
            </div>
        EOS;
    }
    $html .= '</div>';

    return $html;
}


function mostrarMenuPro()
{
	$app = Aplicacion::getSingleton();

    $html = '<ul class="mAdmin">';

    if ($app->esAdmin())
    {
        $html .= <<<EOS
            <li><a href="#">Usuarios</a>
                <ul>
                    <li><a href="usuarios.php">Ver Usuarios</a></li>
                    <li><a href="registro.php">Registrar Usuario</a></li>
                </ul>
            </li>
        EOS;
    }
    if ($app->esAdmin() || $app->esGestor()) {
        $html .= <<<EOS
            <li><a href="#">Peliculas</a>
                <ul>
                    <li><a href="peliculas.php">Películas</a></li>
                    <li><a href="nuevaPelicula.php">Añadir Pelicula</a></li>
                    <li><a href="generos.php">Ver Géneros</a></li>
                    <li><a href="nuevoGenero.php">Añadir Género</a></li>
                    <li><a href="actoresDirectores.php">Ver Actores y Directores</a></li>
                    <li><a href="nuevoActorDirector.php">Añadir Actor o Director</a></li>
                    <li><a href="plataformas.php">Ver Plataformas</a></li>
                    <li><a href="nuevaPlataforma.php">Añadir Plataforma</a></li>
                </ul>
            </li>
            <li><a href="#">Suscripciones</a>
                <ul>
                    <li><a href="premium.php">Ver Planes</a></li>
                    <li><a href="nuevoPlan.php">Añadir Plan</a></li>
                </ul>
            </li>
        EOS;
    }
    if ($app->esAdmin() || $app->esGestor() || $app->esModerador()) {
        $html .= <<<EOS
            <li><a href="#">Eventos y Temas</a>
                <ul>
                    <li><a href="foro.php">Ver Eventos y Temas</a></li>
                    <li><a href="nuevoEventoTema.php">Añadir Evento o Tema</a></li>
                </ul>
            </li>
            </ul>
            </div>
        EOS;
    }

    return $html;
}


function listaActoresDirectoresUser($user = NULL, $limit = NULL, $actorDirector)
{		
    $html = '<div>';
    $actoresDirectores = ActorDirector::buscaActoresDirectoresPorUser($user, $limit, $actorDirector);
    foreach($actoresDirectores as $actorDirector) {
        $href = RUTA_APP.'actorDirector.php?id=' . $actorDirector->id();
        $year = substr($actorDirector->birth_date(), 0, 4);

        $html .=<<<EOS
            <div class="div-actoresDirectores">
            <img id="prof_pic_long" src="img/actores_directores/{$actorDirector->image()}" alt="{$actorDirector->name()}" >
            <div>
            <p><a href="$href">{$actorDirector->name()}</a></p>
            <p>{$year}</p>
            </div>
            </div>
        EOS;
    }
    $html .= '</div>';

    return $html;
}

if(array_key_exists('eliminarNoti', $_POST)) {
    $idNoti= $_POST['idNoti'];
    $app = Aplicacion::getSingleton();
    if ($app->usuarioLogueado()) {
        eliminarNotificacionPorId($idNoti);
        header('Refresh: 0');
    }
}

function listaNotificacionesUser($user = NULL)
{
    $app = Aplicacion::getSingleton();
    $RUTA_APP = RUTA_APP;

    $notificaciones = Notificacion::getNotificacionesCompletadas($user);
	$html = '<div>';
	if($notificaciones !=null){
        $html .= '<h3> Completadas: </h3>';
        foreach($notificaciones as $notificacion) {
			$pelicula = Pelicula::buscaPorId($notificacion->film_id());
            $html .= <<<EOS
                <div class="row-item">
                <p>- <a href="{$RUTA_APP}usuario.php?id={$notificacion->user_review()}">{$notificacion->user_review()}</a> ha escrito una <a href="{$RUTA_APP}reviews.php?id={$notificacion->user_review()}&film={$notificacion->film_id()}"> review </a> para la película <a href="{$RUTA_APP}pelicula.php?id={$notificacion->film_id()}">{$pelicula->title()}</a></p>
                </div>
            EOS;
			if ($app->usuarioLogueado() && ($app->esModerador() || $app->esAdmin() || $notificacion->user_notify() == $app->user())) {
                $html .= <<<EOS
                    <form method="post">
                        <input type="hidden" name="idNoti" value="{$notificacion->id()}" readonly/>
                        <input type="submit" name="eliminarNoti"
                                class="button" value="Marcar como leída" />
                    </form>
                EOS;
            }
        }
    }

    $notificaciones = Notificacion::getNotificacionesPendientes($user);
	if($notificaciones !=null){
        $html .= '<h3> Pendientes: </h3>';
        foreach($notificaciones as $notificacion) {
			$pelicula = Pelicula::buscaPorId($notificacion->film_id());
            $html .= <<<EOS
                <div class="row-item">
                <p>- Se te notificará cuando <a href="{$RUTA_APP}usuario.php?id={$notificacion->user_review()}">{$notificacion->user_review()}</a> publique una review para la película <a href="{$RUTA_APP}pelicula.php?id={$notificacion->film_id()}">{$pelicula->title()}</a></p>
                </div>
            EOS;
			if ($app->usuarioLogueado() && ($app->esModerador() || $app->esAdmin() || $notificacion->user_notify() == $app->user())) {
                $html .= <<<EOS
                    <form method="post">
                        <input type="hidden" name="idNoti" value="{$notificacion->id()}" readonly/>
                        <input type="submit" name="eliminarNoti"
                                class="button" value="Eliminar" />
                    </form>
                EOS;
            }
        }
    }
    $html .= '</div>';

    return $html;
}

function listaReviewsUser($user = NULL, $film_id = NULL)
{		
	$app = Aplicacion::getSingleton();

    if ($user == null && $film_id == null) {
        $users = Usuario::listaAmigos($app->user());
        foreach ($users as $user) {
            $reviews = Review::buscaReviewsPorIdUser($user->user());
            $prevLink = urlencode($_SERVER['REQUEST_URI']);
            $html = '<div>';
            if($reviews !=null){
                
                foreach($reviews as $review) {
                    $pelicula = Pelicula::buscaPorId($review->film_id());
                    if ($film_id == NULL || $film_id == $pelicula->id()) {
                        $html .= '<div class="div-reviewsPeli">';
                        $html .= '<div>';
                        $html .= "<p><a href=\"./pelicula.php?id={$pelicula->id()}\">{$pelicula->title()}</a></p>";
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

                }
                
            }
            $html .= '</div>';
        }
    } else {
        $reviews = Review::buscaReviewsPorIdUser($user);
        $prevLink = urlencode($_SERVER['REQUEST_URI']);
        $html = '<div>';
        if($reviews !=null){
            
            foreach($reviews as $review) {
                $pelicula = Pelicula::buscaPorId($review->film_id());
                if ($film_id == NULL || $film_id == $pelicula->id()) {
                    $html .= '<div class="div-reviewsPeli">';
                    $html .= '<div>';
                    $html .= "<p><a href=\"./pelicula.php?id={$pelicula->id()}\">{$pelicula->title()}</a></p>";
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

            }
            
        }
        $html .= '</div>';
    }

    return $html;
}

function listadoUsuarios()
{
	$app = Aplicacion::getSingleton();
    $html = '<a href="'.RUTA_APP.'registro.php">Registrar usuario</a>';
    $prevLink = urlencode($_SERVER['REQUEST_URI']);
    $usuarios = Usuario::listaUsuarios();
    foreach($usuarios as $usuario) {
        
        $html .= '<div class="row-item">';
        $html .= "<p>{$usuario->name()} ({$usuario->user()}) [{$usuario->date_joined()}]  ";
        if ($app->usuarioLogueado() && $app->esAdmin()) {
            $html .= '<a href="'.RUTA_APP.'editarPerfil.php?id='.$usuario->user().'&prevPage='.$prevLink.'&isSelf=0">Editar</a>';
            $html .= '<a href="'.RUTA_APP.'eliminarUsuario.php?id='.$usuario->user().'&prevPage='.$prevLink.'"> Eliminar</a>';
        }
        $html .= '</p></div>';
    }

    return $html;
}

function busquedaUsuarios($search)
{
    $usuarios = Usuario::busqueda($search);
    $html = '';
    if (!empty($usuarios)) {
        $html .= '<h3> Usuarios: </h3>';
        $html .= '<ul>';
        foreach($usuarios as $usuario) {
            $html .= '<p><a href="'.RUTA_APP.'usuario.php?id='.$usuario->user().'">'.$usuario->name().' ('.$usuario->user().')</a></p>';
        }
        $html .= '</ul>';
    }

    return $html;
}

function addNotificacion($user_notify, $user_review, $film_id)
{
    $notificacion = Notificacion::crea($user_review, $user_notify, $film_id);
    $review = Review::getReviewPorUserPelicula($user_review, $film_id);
    if ($review) {
        Notificacion::addReview($notificacion->id(), $review->id());
    }
}

function delNotificacion($id)
{
    Notificacion::borraPorId($id);
}

function getNotificacion($user_notify, $user_review, $film_id)
{
    return Notificacion::getNotificacion($user_notify, $user_review, $film_id);
}

function getNotificacionesCompletadas($user)
{
    $usuario = getUsuarioPorUser($user);
    return $usuario->completedNotifications();
}

function getUsuarioPorUser($user)
{
    return Usuario::buscaUsuario($user);
}

function getReviewPorUser($user)
{
    return Review::buscaReviewsPorIdUser($user);
}

function isUsuarioAmigo($user, $amigo) 
{
    return Usuario::isUsuarioAmigo($user, $amigo);
}

function addAmigo($user, $amigo) 
{
    Usuario::addAmigo($user, $amigo);
}

function delAmigo($user, $amigo) 
{
    Usuario::delAmigo($user, $amigo);
}

function eliminarUsuarioPorUser($user)
{
    return Usuario::borraPorUser($user);
}

function eliminarNotificacionPorId($id)
{
    return Notificacion::borraPorId($id);
}