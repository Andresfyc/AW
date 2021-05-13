<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/peliculas_utils.php';

use es\ucm\fdi\aw\Aplicacion;

$idPelicula = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$pelicula = buscaPeliculaPorId($idPelicula);

$tituloPagina = 'Eliminar Película';

$dateReleased = substr($pelicula->date_released(), 0, 4);

if(array_key_exists('cancelar', $_POST)) {
    header('Location: '.RUTA_APP.'peliculas.php');
}
else if(array_key_exists('eliminar', $_POST)) {
    $app = Aplicacion::getSingleton();
    if ($app->usuarioLogueado() && ($app->esGestor() || $app->esAdmin())) {
        eliminarPeliculaPorId($idPelicula);
        header('Location: '.RUTA_APP.'peliculas.php');
    }
}

$contenidoPrincipal = <<<EOS
    <h1>Eliminar Película</h1>
    <p> ¿Quiere eliminar definitivamente la película "{$pelicula->title()} ({$dateReleased})"?</p>
    <form method="post">
        <input type="submit" name="cancelar"
                class="button" value="Cancelar" />
            
        <input type="submit" name="eliminar"
                class="button" value="Eliminar" />
    </form>
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';