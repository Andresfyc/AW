<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/foro_utils.php';

use es\ucm\fdi\aw\Aplicacion;

$idMensaje = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$mensaje = buscaMensajePorId($idMensaje);

$tituloPagina = 'Eliminar Mensaje';

if(array_key_exists('cancelar', $_POST)) {
    header('Location: '.RUTA_APP.'eventoTema.php?id='.$mensaje->evento_tema_obj()->id().'&nombre='.$mensaje->evento_tema_obj()->name().'&time='.$mensaje->evento_tema_obj()->time().'.php');
}
else if(array_key_exists('eliminar', $_POST)) {
    $app = Aplicacion::getSingleton();
    if ($app->usuarioLogueado() && ($app->esModerador() || $app->esAdmin()) || $mensaje->user() == $app->user()) {
        eliminarMensajePorId($idMensaje);
        header('Location: '.RUTA_APP.'eventoTema.php?id='.$mensaje->evento_tema_obj()->id().'&nombre='.$mensaje->evento_tema_obj()->name().'&time='.$mensaje->evento_tema_obj()->time().'.php');
    }
}

$contenidoPrincipal = <<<EOS
<h1>Eliminar Mensaje</h1>
<p> ¿Quiere eliminar definitivamente el mensaje "{$mensaje->text()}"?</p>
<form method="post">
    <input type="submit" name="cancelar"
            class="button" value="Cancelar" />
        
    <input type="submit" name="eliminar"
            class="button" value="Eliminar" />
</form>
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';