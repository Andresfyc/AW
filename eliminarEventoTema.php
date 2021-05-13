<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/foro_utils.php';

use es\ucm\fdi\aw\Aplicacion;

$idEventoTema = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$nameEventoTema = filter_input(INPUT_GET, 'name', FILTER_SANITIZE_STRING);

$tituloPagina = 'Eliminar Evento/Tema';

if(array_key_exists('cancelar', $_POST)) {
    header('Location: '.RUTA_APP.'/foro.php');
}
else if(array_key_exists('eliminar', $_POST)) {
    $app = Aplicacion::getSingleton();
    if ($app->usuarioLogueado() && ($app->esGestor() || $app->esAdmin())) {
        eliminarEventoTemaPorId($idEventoTema);
        header('Location: '.RUTA_APP.'/foro.php');
    }
}

$contenidoPrincipal = <<<EOS
    <h1>Eliminar evento/tema</h1>
    <p> ¿Quiere eliminar definitivamente el evento/tema {$nameEventoTema}?</p>
    <form method="post">
        <input type="submit" name="cancelar"
                class="button" value="Cancelar" />
            
        <input type="submit" name="eliminar"
                class="button" value="Eliminar" />
    </form>
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';