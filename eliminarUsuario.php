<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/usuarios_utils.php';

use es\ucm\fdi\aw\Aplicacion;

$user = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
$prevPage = filter_input(INPUT_GET, 'prevPage', FILTER_SANITIZE_STRING);

$usuario = getUsuarioPorUser($user);

$tituloPagina = 'Eliminar Usuario';

$prev = urldecode($prevPage);
if(array_key_exists('cancelar', $_POST)) {
    header('Location: '.$prev);
}
else if(array_key_exists('eliminar', $_POST)) {
    $app = Aplicacion::getSingleton();
    if ($app->usuarioLogueado() && ($app->esAdmin())) {
        eliminarUsuarioPorUser($user);
        header('Location: '.$prev);
    }
}

$contenidoPrincipal = <<<EOS
    <h1>Eliminar Usuario</h1>
    <p> ¿Quiere eliminar definitivamente el usuario "{$usuario->name()}" ({$usuario->user()})?</p>
    <form method="post">
        <input type="submit" name="cancelar"
                class="button" value="Cancelar" />
            
        <input type="submit" name="eliminar"
                class="button" value="Eliminar" />
    </form>
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';