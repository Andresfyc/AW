<?php
use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\mensajes\Mensaje;
use es\ucm\fdi\aw\eventosTemas\EventoTema;

/*
 * Funciones de apoyo
 */

function listaMensajes($id) {
	$app = Aplicacion::getSingleton();
    $html = '';
    $mensajes = Mensaje::buscaMensajesPorIdEventoTema($id);
    foreach($mensajes as $mensaje) {
    
        $html .= '<div class="row-mensaje">';
        $html .= "{$mensaje->text()} ({$mensaje->user()}) [{$mensaje->time_created()}]  ";
        if ($app->usuarioLogueado() && ($app->esModerador() || $app->esAdmin()) || $mensaje->user() == $app->user()) {
            $html .= "<a href=\"./editarMensaje.php?id={$mensaje->id()}\">Editar</a>";
            $html .= "<a href=\"./eliminarMensaje.php?id={$mensaje->id()}\"> Eliminar</a>";
        }
        $html .= '</div>';
    }

    return $html;
}

function listaEventos() {
	$app = Aplicacion::getSingleton();
    $html=<<<EOS
        <h3>Eventos</h3>
        <div class="row-top">
            <div class="col" id="col-4-1">
                <p>Nombre</p>
            </div>
            <div class="col" id="col-4-2">
                <p>Descripción</p>
            </div>
            <div class="col" id="col-4-3">
                <p>Fecha y/o Hora</p>
            </div>
            <div class="col" id="col-4-4">
                <p>#Mensajes</p>
            </div>
        </div>
    EOS;

    $eventos = EventoTema::buscaEventosRecientes();
    foreach($eventos as $evento) {
        $href = './eventoTema.php?id=' . $evento->id() . '&name=' . $evento->name() . '&time=' . $evento->time();
        $editarEliminar = '';
        if ($app->usuarioLogueado() && ($app->esGestor() || $app->esAdmin())) {
            $editarEliminar .= "<p><a href=\"./editarEventoTema.php?id={$evento->id()}\">Editar</a> <a href=\"./eliminarEventoTema.php?id={$evento->id()}&name={$evento->name()}\">Eliminar</a></p>";
        }

        $html.=<<<EOS
            <div class="row">
            <div class="col" id="col-4-1">
            <p><a href="$href">{$evento->name()} </a></p>
            $editarEliminar
            </div>
            <div class="col" id="col-4-2">
            <p>{$evento->description()}</p>
            </div>
            <div class="col" id="col-4-3">
            <p>{$evento->time()}</p>
            </div>
            <div class="col" id="col-4-4">
            <p>{$evento->num_messages()}</p>
            </div>
            </div>
        EOS;
    }

    return $html;
}

function listaTemas() {
	$app = Aplicacion::getSingleton();
    $html=<<<EOS
        <h3>Temas</h3>
        <div class="row-top">
            <div class="col" id="col-3-1">
                <p>Nombre</p>
            </div>
            <div class="col" id="col-3-2">
                <p>Descripción</p>
            </div>
            <div class="col" id="col-3-3">
                <p>#Mensajes</p>
            </div>
        </div>
    EOS;

    $temas = EventoTema::buscaTemas();
    foreach($temas as $tema) {
        $href = './eventoTema.php?id=' . $tema->id() . '&name=' . $tema->name() . '&time=' . $tema->time();
        $editarEliminar = '';
        if ($app->usuarioLogueado() && ($app->esGestor() || $app->esAdmin())) {
            $editarEliminar .= "<p><a href=\"./editarEventoTema.php?id={$tema->id()}\">Editar</a> <a href=\"./eliminarEventoTema.php?id={$tema->id()}&name={$tema->name()}\">Eliminar</a></p>";
        }

        $html.=<<<EOS
            <div class="row">
            <div class="col" id="col-3-1">
            <p><a href="$href">{$tema->name()} </a></p>
            $editarEliminar
            </div>
            <div class="col" id="col-3-2">
            <p>{$tema->description()}</p>
            </div>
            <div class="col" id="col-3-3">
            <p>{$tema->num_messages()}</p>
            </div>
            </div>
        EOS;
    }
    
    return $html;
}

function eliminarEventoTemaPorId($id)
{
    return EventoTema::borraPorId($id);
}

function eliminarMensajePorId($id)
{
    return Mensaje::borraPorId($id);
}

function buscaMensajePorId($id)
{
    return Mensaje::buscaPorId($id);
}
