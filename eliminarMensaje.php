<?php

require_once __DIR__.'/includes/config.php';

$idMensaje = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$mensajes = new es\ucm\fdi\aw\mensajes();
$mensaje = $mensajes->getMensajePorId($idMensaje);

$tituloPagina = 'Eliminar Mensaje';

$time_created = substr($mensaje->time_created(), 0, 4);

if(array_key_exists('cancelar', $_POST)) {
    header('Location: Foro.php');
}
else if(array_key_exists('eliminar', $_POST)) {
    $mensajes->eliminarMensajePorId($idMensaje);
    header('Location: Foro.php');
}

$contenidoPrincipal = <<<EOS
<h1>Eliminar Mensaje</h1>
<p> ¿Quiere eliminar definitivamente el mensaje {$mensaje->text()} ({$time_created})?</p>
<form method="post">
    <input type="submit" name="cancelar"
            class="button" value="Cancelar" />
        
    <input type="submit" name="eliminar"
            class="button" value="Eliminar" />
</form>
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';