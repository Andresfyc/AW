<?php

require_once __DIR__.'/includes/config.php';

$idPelicula = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$peliculas = new es\ucm\fdi\aw\peliculas();
$pelicula = $peliculas->getPeliculaPorId($idPelicula);

$form = new es\ucm\fdi\aw\FormularioEditarPelicula($pelicula);
$htmlFormEditarPelícula = $form->gestiona();

$tituloPagina = 'Editar Película';

$contenidoPrincipal = <<<EOS
<h1>Editar Película</h1>
$htmlFormEditarPelícula
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';