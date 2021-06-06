<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/usuarios_utils.php';
require_once __DIR__.'/includes/comun/peliculas_utils.php';

use es\ucm\fdi\aw\Aplicacion;

$idPelicula = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$prevPage = filter_input(INPUT_GET, 'prevPage', FILTER_SANITIZE_STRING);
$prevPageId = filter_input(INPUT_GET, 'prevId', FILTER_SANITIZE_NUMBER_INT);

if (strlen($prevPageId) > 0) {
    $prev = RUTA_APP . $prevPage . ".php?id=" . $prevPageId;
} else {
    $prev = RUTA_APP . $prevPage . ".php";
}

$form = new es\ucm\fdi\aw\reviews\FormularioNuevaReview($idPelicula, $prev);
$htmlFormNuevaReview = $form->gestiona();

$tituloPagina = 'Añadir Review';

$app = Aplicacion::getSingleton();
$user = $app->user();
$reviews = getReviewPorIdPelicula($idPelicula);

if(!existeReviewUsuarioPelicula($idPelicula, $user)){
    $contenidoPrincipal = <<<EOS
    <!--       <h1>Añadir Review</h1>-->
        $htmlFormNuevaReview
    EOS;
}  else{
    $contenidoPrincipal = <<<EOS
        <h1>Ya ha creado una review en esta película</h1>
    EOS;
}


require __DIR__.'/includes/plantillas/plantilla.php';