<?php

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\usuarios\Usuario;
use es\ucm\fdi\aw\actoresDirectores\ActorDirector;

/*
 * Funciones de apoyo
 */

function getDivUsuario() {
    $RUTA_APP = RUTA_APP;
	$app = Aplicacion::getSingleton();
    $usuario = getUsuarioPorUser($app->user());
    if ($app->usuarioLogueado()) {
        $html=<<<EOS
            <div class="div-perfil">
            <img id="film_pic" src="img/usuarios/{$app->image()}" alt="user" >
            <div>
            <p>Usuario: {$usuario->user()}</p>
            <p>Nombre completo: {$usuario->name()}</p>
            <p>Correo electrónico: </p>
            <p>Fecha de registro: {$usuario->date_joined()}</p>
            <p><a href="{$RUTA_APP}editarPerfil.php?user={$usuario->user()}">Editar Perfil</a></p>
            </div>
            </div>
        EOS;
        return $html;
    }
}
function getUsuario() {
    $RUTA_APP = RUTA_APP;
	$app = Aplicacion::getSingleton();
    $usuario = getUsuarioPorUser($app->user());
	return $usuario;
}

function listaAmigos($user, $limit=NULL)
{
    $usuarios = Usuario::listaAmigos($user, $limit);
    $html = '<div>';
    foreach($usuarios as $usuario) {
        $href = RUTA_APP.'usuarios.php?id=' . $usuario->user();
        $peliculaWatching = $usuario->film();
        $watching = '';
        $swapper='<p><a href="perfilAmigo.php?id='.$usuario->user().'"> Swapper: '.$usuario->user().' </a></p>';
        if ($peliculaWatching) {
            $watching .= '<p><a href="'.RUTA_APP.'pelicula.php?id='.$peliculaWatching->id().'"> Viendo: '.$peliculaWatching->title().' </a></p>';
        }

        $html .=<<<EOS
            <div class="div-usuarios">
            <div class="div-usuarios">
            <div class="usuarios">
            <img id="prof_pic" src="img/usuarios/{$usuario->image()}" alt="user" >
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


function listaActoresDirectoresUser($user = NULL, $limit = NULL, $actorDirector)
{		
    $html = '<div>';
    $actores = ActorDirector::buscaActoresDirectoresPorUser($user, $limit, $actorDirector);
    foreach($actores as $actor) {
        $href = RUTA_APP.'actorDirector.php?id=' . $actor->id();
        $year = substr($actor->birth_date(), 0, 4);

        $html .=<<<EOS
            <div class="div-actoresDirectores">
            <img id="prof_pic_long" src="img/actores_directores/{$actor->image()}" alt="actor/director" >
            <div>
            <p><a href="$href">{$actor->name()}</a></p>
            <p>{$year}</p>
            </div>
            </div>
        EOS;
    }
    $html .= '</div>';

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

function getUsuarioPorUser($user)
{
    return Usuario::buscaUsuario($user);
}
