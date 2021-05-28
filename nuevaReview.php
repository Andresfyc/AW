<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/usuarios_utils.php';
require_once __DIR__.'/includes/comun/peliculas_utils.php';

$idPelicula = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$form = new es\ucm\fdi\aw\reviews\FormularioNuevaReview($idPelicula);
$htmlFormNuevaReview = $form->gestiona();

$tituloPagina = 'Añadir Review';

$Usuario = getUsuario();
$reviews = getReviewPorIdPelicula($idPelicula);
$encontrado=false;
if($reviews!=null){
    foreach($reviews as $review){
        if($Usuario->user() == $review->user() ){
            $encontrado=true;
        }
    }
}

if(!$encontrado){
    $contenidoPrincipal = <<<EOS
    
    <h1>Añadir Review</h1>
        $htmlFormNuevaReview
    EOS;
}  else{
    $contenidoPrincipal = <<<EOS
    
    <h1>Ya ha creado una review en esta película</h1>
    EOS;
}


require __DIR__.'/includes/plantillas/plantilla.php';