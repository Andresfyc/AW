<?php

require_once __DIR__.'/includes/config.php';

$idReview = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$reviews = new es\ucm\fdi\aw\reviews();
$review = $reviews->getReviewPorId($idReview);

$tituloPagina = 'Eliminar Review';

if(array_key_exists('cancelar', $_POST)) {
    header("Location: pelicula.php?id={$review->film_id()}.php");
}
else if(array_key_exists('eliminar', $_POST)) {
    $reviews->eliminarReviewPorId($idReview);
    header("Location: pelicula.php?id={$review->film_id()}.php");
}

$contenidoPrincipal = <<<EOS
<h1>Eliminar Review</h1>
<p> ¿Quiere eliminar definitivamente la review ({$review->stars()}/5) "{$review->review()}"?</p>
<form method="post">
    <input type="submit" name="cancelar"
            class="button" value="Cancelar" />
        
    <input type="submit" name="eliminar"
            class="button" value="Eliminar" />
</form>
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';